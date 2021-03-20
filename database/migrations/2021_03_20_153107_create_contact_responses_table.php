<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Tipoff\Forms\Models\Contact;

class CreateContactResponsesTable extends Migration
{
    public function up()
    {
        Schema::create('contact_responses', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Contact::class);
            $table->dateTime('emailed_at')->nullable();
            $table->dateTime('closed_at')->nullable();
            $table->timestamp('created_at');
        });
    }
}
