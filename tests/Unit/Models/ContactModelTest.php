<?php

declare(strict_types=1);

namespace Tipoff\Forms\Tests\Unit\Models;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tipoff\Forms\Enums\ContactStatus;
use Tipoff\Forms\Models\Contact;
use Tipoff\Forms\Tests\TestCase;
use Tipoff\Statuses\Models\StatusRecord;
use Tipoff\Authorization\Models\User;

class ContactModelTest extends TestCase
{
    use DatabaseTransactions;
    use WithFaker;

    /** @test */
    public function create()
    {
        $model = Contact::factory()->create();
        $this->assertNotNull($model);
    }

    /** @test */
    public function can_set_status()
    {
        $this->actingAs(User::factory()->create());

        /** @var Contact $contact */
        $contact = Contact::factory()->create();
        $contact->setContactStatus(ContactStatus::SUBMITTED());
        $this->assertEquals(ContactStatus::SUBMITTED, $contact->getContactStatus()->getValue());

        $history = $contact->getContactStatusHistory()
            ->map(function (StatusRecord $statusRecord) {
                return (string) $statusRecord->status;
            })->toArray();

        $this->assertEquals([ContactStatus::SUBMITTED], $history);
    }
}
