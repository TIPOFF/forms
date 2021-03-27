<?php

declare(strict_types=1);

namespace Tipoff\Forms\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Panel;
use Tipoff\Forms\Enums\ContactStatus;
use Tipoff\Forms\Enums\FormType;
use Tipoff\Support\Nova\BaseResource;
use Tipoff\Support\Nova\Fields\Enum;

class Contact extends BaseResource
{
    public static $model = \Tipoff\Forms\Models\Contact::class;

    public static $title = 'reference_number';

    public static $search = [
        'id',
        'reference_number',
    ];

    public static $group = 'Forms';

    /** @psalm-suppress UndefinedClass */
    protected array $filterClassList = [
        \Tipoff\Locations\Nova\Filters\Location::class,
    ];

    public function fieldsForIndex(NovaRequest $request)
    {
        return array_filter([
            ID::make(),
            nova('location') ? BelongsTo::make('Location', 'location', nova('location'))->sortable() : null,
            Text::make('Form Type')->sortable(),
            Text::make('Number', 'reference_number')->sortable(),
            Enum::make('ContactStatus', function (\Tipoff\Forms\Models\Contact $contact) {
                return $contact->getContactStatus();
            })->attach(ContactStatus::class)->sortable(),
            nova('user') ? BelongsTo::make('User', 'user', nova('user'))->sortable() : null,
            DateTime::make('Submitted', 'created_at')->sortable(),
        ]);
    }

    public function fields(Request $request)
    {
        return array_filter([
            Text::make('Number', 'reference_number')->exceptOnForms(),
            nova('location') ? BelongsTo::make('Location', 'location', nova('location'))->required()->hideWhenUpdating() : null,
            Select::make('Form Type')->options([
                FormType::CONTACT => 'Contact',
                FormType::RESERVATIONS => 'Reservations',
                FormType::PARTIES => 'Parties',
                FormType::GROUPS => 'Groups',
                FormType::EMPLOYMENT => 'Employment',
            ])->required()->hideWhenUpdating(),
            Enum::make('ContactStatus', function (\Tipoff\Forms\Models\Contact $contact) {
                return $contact->getContactStatus();
            })->attach(ContactStatus::class),
            Text::make('First Name', 'first_name')->hideWhenUpdating(),
            Text::make('Last Name', 'last_name')->hideWhenUpdating(),
            nova('user') ? BelongsTo::make('User', 'user', nova('user'))->nullable()->hideWhenUpdating() : null,
            nova('email_address') ? BelongsTo::make('Email Address', 'email', nova('email_address'))->required()->hideWhenUpdating() : null,
            nova('phone') ? BelongsTo::make('Phone', 'phone', nova('phone'))->nullable() : null,
            Text::make('Company Name')->nullable()->hideWhenUpdating(),

            new Panel('Submission Details', $this->submissionFields()),

            new Panel('Data Fields', $this->dataFields()),
        ]);
    }

    protected function submissionFields()
    {
        return [
            Textarea::make('Message')->rows(3)->alwaysShow()->nullable()->hideWhenUpdating(),
//             Number::make('Participants', 'fields->participants')->nullable()->hideWhenUpdating(),
//             Date::make('Requested Date', 'fields->requested_date')->nullable()->hideWhenUpdating(),
//             Text::make('Requested Time', 'fields->requested_time')->nullable()->hideWhenUpdating(),
        ];
    }

    protected function dataFields(): array
    {
        return array_merge(
            parent::dataFields(),
            $this->creatorDataFields(),
            $this->updaterDataFields(),
        );
    }
}
