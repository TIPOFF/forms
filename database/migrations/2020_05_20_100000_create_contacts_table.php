<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactsTable extends Migration
{
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->string('form_type')->index(); // String title of the form type so know which one was completed
            $table->string('reference_number')->index()->unique(); // Generated by system. This is identifier used to communicate with customer about their contact form. Reference number is emailed to them.
            $table->foreignIdFor(app('user'))->index(); // Will create a user for every form submission, so all need email, first & last name now.
            $table->foreignIdFor(app('location'))->index();
            $table->string('phone')->nullable(); // Will need to format before saving
            $table->smallInteger('participants')->nullable();
            $table->date('requested_date')->nullable();
            $table->time('requested_time')->nullable(); // Stored in location timezone
            $table->string('company_name')->nullable();
            $table->text('message')->nullable();
            $table->json('additional_fields')->nullable();
            $table->dateTime('emailed_at')->nullable();
            $table->dateTime('closed_at')->nullable();
            $table->softDeletes(); // Soft delete if email bounces or if the contact submission is spam.
            $table->timestamps();
        });
    }
}