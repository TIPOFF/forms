<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Tipoff\Forms\Enums\ContactStatus;
use Tipoff\Statuses\Models\Status;

class AddContactStatuses extends Migration
{
    public function up()
    {
        Status::publishStatuses(ContactStatus::statusType(), ContactStatus::getValues());
    }
}
