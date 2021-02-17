<?php

declare(strict_types=1);

namespace Tipoff\Forms\Tests\Unit\Models;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tipoff\Forms\Models\Contact;
use Tipoff\Forms\Tests\TestCase;

class ContactModelTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function create()
    {
        $model = Contact::factory()->create();
        $this->assertNotNull($model);
    }
}
