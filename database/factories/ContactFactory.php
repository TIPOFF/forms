<?php 

declare(strict_types=1);

namespace Tipoff\Forms\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Tipoff\Forms\Models\Contact;

class ContactFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Contact::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'form_type'      => $this->faker->randomElement(['contact', 'reservation', 'parties', 'groups', 'employment']),
            'user_id'        => randomOrCreate(app('user')),
            'location_id'    => randomOrCreate(app('location')),
            'phone'          => '555-555-5555',
            'participants'   => $this->faker->numberBetween(10, 200),
            'requested_date' => $this->faker->dateTimeBetween($startDate = 'now', $endDate = '+6 months')->format('Y-m-d'),
            'company_name'   => $this->faker->company,
            'message'        => $this->faker->paragraph,
        ];
    }
}
