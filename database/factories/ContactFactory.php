<?php

declare(strict_types=1);

namespace Tipoff\Forms\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Tipoff\Forms\Enums\FormType;
use Tipoff\Forms\Models\Contact;

class ContactFactory extends Factory
{
    protected $model = Contact::class;

    public function definition()
    {
        return [
            'form_type'      => $this->faker->randomElement(FormType::getValues()),
            'location_id'    => randomOrCreate(app('location')),
            'email'          => $this->faker->email,
            'first_name'     => $this->faker->firstName,
            'last_name'      => $this->faker->lastName,
            'phone'          => '555-555-5555',
            'company_name'   => $this->faker->company,
            'message'        => $this->faker->paragraph,
        ];
    }
}
