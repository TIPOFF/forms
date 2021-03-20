<?php

declare(strict_types=1);

namespace Tipoff\Forms\Tests\Unit\Models;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tipoff\Forms\Models\ContactResponse;
use Tipoff\Forms\Tests\TestCase;

class ContactResponseModelTest extends TestCase
{
    use DatabaseTransactions;
    use WithFaker;

    /** @test */
    public function create()
    {
        $model = ContactResponse::factory()->create();
        $this->assertNotNull($model);
    }
}
