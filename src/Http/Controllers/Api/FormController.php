<?php

declare(strict_types=1);

namespace Tipoff\Forms\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Tipoff\Forms\Models\Contact;
use Tipoff\Support\Http\Controllers\Api\BaseApiController;

class FormController extends BaseApiController
{
    public function __invoke(Request $request)
    {
        $domain = request('__amp_source_origin');

        $basic = [
            'contact',
            'employment',
        ];
        if (in_array($request->form_type, $basic)) {
            $validator = Validator::make($request->all(), [
                'form_type' => [    'required',
                    Rule::in([
                        'contact',
                        'employment',
                    ]),
                ],
                'first_name' => 'required',
                'last_name' => 'required',
                'email_address' => 'required|email',
                'phone' => 'required',
                'message' => 'nullable|max:3000',
            ]);
        } else {
            $validator = Validator::make($request->all(), [
                'form_type' => [    'required',
                    Rule::in([
                        'on-the-run',
                        'parties',
                        'reservations',
                        'team-building',
                    ]),
                ],
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => 'required|email',
                'phone' => 'required',
                'message' => 'nullable|max:3000',
                'company_name' => 'nullable|string',
            ]);
        }

        if ($validator->fails()) {
            $messages = collect($validator->errors()->getMessages())->map(function ($messages, $key) {
                return ['name' => $key, 'message' => reset($messages)];
            })->values()->toArray();

            return response(['verifyErrors' => $messages], 500)
                ->header('AMP-Access-Control-Allow-Source-Origin', $domain);
        }

        // Don't save spam messages where first name is same as last name
        if ($request->first_name !== $request->last_name) {

            // Find or create the user
            $user = app('user')->where('email', $request->email)->first();
            if (! $user) {
                $user = app('user')->updateOrCreate(
                    ['email' => $request->email],
                    [
                        'first_name' => $request->first_name,
                        'last_name' => $request->last_name,
                    ]
                );
            }
            // Todo: How is this handled now?
            //$user->locations()->attach($location);

            // Create the contact database entry
            $contact = new Contact();
            $contact->user_id = $user->id;
            $contact->location_id = $request->location_id;
            $contact->form_type = $request->form_type;
            $contact->phone = $request->phone;
            $contact->message = $request->message;
            if (! in_array($request->form_type, $basic)) {
                $contact->company_name = $request->company;
                $contact->fields->requested_date = $request->requested_date;
                $contact->fields->requested_time = $request->requested_time;
                $contact->fields->participants = $request->participants;
            }
            $contact->save();
        }

        $path = (in_array($request->form_type, config('tipoff.forms.active')))
            ? $request->form_type
            : null;

        return response([
            'message' => 'Thank you for contacting The Great Escape Room.',
        ])
            ->header('AMP-Access-Control-Allow-Source-Origin', $domain)
            ->header('AMP-Access-Expose-Headers', 'AMP-Access-Control-Allow-Source-Origin')
            ->header('Access-Control-Expose-Headers', 'AMP-Redirect-To')
            ->header('AMP-Redirect-to', url(config('app.url').$path.'/confirmation'));
    }
}
