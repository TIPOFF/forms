<?php

declare(strict_types=1);

namespace Tipoff\Forms\Tests\Unit\Commands;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tipoff\Forms\Models\Contact;
use Tipoff\Forms\Tests\TestCase;

class AttachContactUsersCommandTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function no_users_found()
    {
        $this->artisan('attach:users');
        $this->assertDatabaseCount('contacts', 0);
    }

    /** @test */
    public function user_found()
    {
        //Create a user and contact with same email, but not attached
        $user = randomOrCreate(app('user'));
        Contact::factory()->create([
            'email' => $user->email
        ]);

        $this->artisan('attach:users');
        $contact = Contact::where('email', '=', $user->email)->first();
        $this->assertNotNull($contact->user);
    }
}
