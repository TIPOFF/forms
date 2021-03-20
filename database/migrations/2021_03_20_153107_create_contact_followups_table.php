<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Tipoff\Forms\Models\Contact;

class CreateContactFollowupsTable extends Migration
{
    public function up()
    {
        Schema::create('contact_followups', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Contact::class);
            $table->dateTime('emailed_at')->nullable();
            $table->dateTime('closed_at')->nullable();
        });
    }
}
