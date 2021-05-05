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
            $table->foreignIdFor(Contact::class)->index();
            $table->text('message')->nullable(); // Message will be communication to or from contact user
            $table->text('comment')->nullable(); // Comment is internal communication. This is more like documentation so it is different than a note attachment from tipoff/notes
            $table->dateTime('emailed_at')->nullable();

            $table->foreignIdFor(app('user'), 'creator_id');
            $table->timestamp('created_at');
            $table->softDeletes();
        });
    }
}
