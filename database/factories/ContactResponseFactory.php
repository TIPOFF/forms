<?php

declare(strict_types=1);

namespace Tipoff\Forms\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Tipoff\Forms\Models\Contact;
use Tipoff\Forms\Models\ContactResponse;

class ContactResponseFactory extends Factory
{
    protected $model = ContactResponse::class;

    public function definition()
    {
        return [
            'contact_id' => Contact::factory()->create()->id,
            'emailed_at' => $this->faker->dateTime,
            'creator_id' => randomOrCreate(app('user')),
        ];
    }
}
