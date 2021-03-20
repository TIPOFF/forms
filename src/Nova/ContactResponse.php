<?php

declare(strict_types=1);

namespace Tipoff\Forms\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Panel;
use Tipoff\Support\Nova\BaseResource;

class ContactResponse extends BaseResource
{
    public static $model = \Tipoff\Forms\Models\ContactResponse::class;

    public static $search = [
        'id',
    ];

    public static $group = 'Forms';

    public function fieldsForIndex(NovaRequest $request)
    {
        return array_filter([
            ID::make(),
        ]);
    }

    public function fields(Request $request)
    {
        return array_filter([
            new Panel('Data Fields', $this->dataFields()),
        ]);
    }

    protected function dataFields(): array
    {
        return [
            ID::make(),
            DateTime::make('Emailed At', 'emailed_at')->exceptOnForms(),
            DateTime::make('Closed At', 'closed_at')->exceptOnForms(),
        ];
    }
}
