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
            Enum::make('ContactStatus', function (\Tipoff\Forms\Models\Contact $contact) {
                return $contact->getContactStatus();
            })->attach(ContactStatus::class)->sortable(),
            Text::make('Form Type')->sortable(),
            Text::make('Number', 'reference_number')->sortable(),
            nova('user') ? BelongsTo::make('User', 'user', nova('user'))->sortable() : null,
            nova('location') ? BelongsTo::make('Location', 'location', nova('location'))->sortable() : null,
            DateTime::make('Submitted', 'created_at')->sortable(),
        ]);
    }

    public function fields(Request $request)
    {
        return array_filter([
            Text::make('Number', 'reference_number')->exceptOnForms(),
            Enum::make('ContactStatus', function (\Tipoff\Forms\Models\Contact $contact) {
                return $contact->getContactStatus();
            })->attach(ContactStatus::class),
            Select::make('Form Type')->options([
                FormType::CONTACT => 'Contact',
                FormType::RESERVATIONS => 'Reservations',
                FormType::PARTIES => 'Parties',
                FormType::GROUPS => 'Groups',
                FormType::EMPLOYMENT => 'Employment',
            ])->required()->hideWhenUpdating(),
            nova('location') ? BelongsTo::make('Location', 'location', nova('location'))->required()->hideWhenUpdating() : null,
            Text::make('First Name', 'first_name')->hideWhenUpdating(),
            Text::make('Last Name', 'last_name')->hideWhenUpdating(),
            nova('user') ? BelongsTo::make('User', 'user', nova('user'))->required()->hideWhenUpdating() : null,
            nova('email_address') ? BelongsTo::make('Email Address', 'email_address', nova('email_address'))->sortable() : null,
            nova('phone') ? BelongsTo::make('Phone', 'phone', nova('phone'))->sortable() : null,
            Text::make('Company Name')->nullable()->hideWhenUpdating(),

            new Panel('Submission Details', $this->submissionFields()),

            new Panel('Data Fields', $this->dataFields()),
        ]);
    }

    protected function submissionFields()
    {
        return [
            Textarea::make('Message')->rows(3)->alwaysShow()->nullable()->hideWhenUpdating(),
            Number::make('Participants', 'fields->participants')->nullable()->hideWhenUpdating(),
            Date::make('Requested Date', 'fields->requested_date')->nullable()->hideWhenUpdating(),
            Text::make('Requested Time', 'fields->requested_time')->nullable()->hideWhenUpdating(),
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
