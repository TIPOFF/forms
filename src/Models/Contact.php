<?php

declare(strict_types=1);

namespace Tipoff\Forms\Models;

use Assert\Assert;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Tipoff\Forms\Enums\ContactStatus;
use Tipoff\Statuses\Traits\HasStatuses;
use Tipoff\Support\Models\BaseModel;
use Tipoff\Support\Traits\HasCreator;
use Tipoff\Support\Traits\HasPackageFactory;
use Tipoff\Support\Traits\HasUpdater;

class Contact extends BaseModel
{
    use HasCreator;
    use HasPackageFactory;
    use HasStatuses;
    use HasUpdater;
    use SoftDeletes;

    protected $casts = [
        'fields' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($contact) {
            Assert::lazy()
                ->that($contact->form_type)->notEmpty('A contact must have a form type.')
                ->that($contact->location_id)->notEmpty('A contact must be made to a location.')
                ->that($contact->email_address_id)->notEmpty('A contact must supply an email address.')
                ->verifyNow();
            $contact->generateReferenceNumber();
        });
    }

    public function getRouteKeyName()
    {
        return 'reference_number';
    }

    public function generateReferenceNumber()
    {
        do {
            $token = Str::of(Carbon::now('America/New_York')->format('ymdB'))->substr(1, 7) . Str::upper(Str::random(3));
        } while (self::where('reference_number', $token)->first()); //check if the token already exists and if it does, try again

        $this->reference_number = $token;
    }

    public function scopeByContactStatus(Builder $query, ContactStatus $contactStatus): Builder
    {
        return $this->scopeByStatus($query, $contactStatus->toStatus());
    }

    public function setContactStatus(ContactStatus $contactStatus): self
    {
        $this->setStatus((string) $contactStatus->getValue(), ContactStatus::statusType());

        return $this;
    }

    public function getContactStatus(): ? ContactStatus
    {
        $status = $this->getStatus(ContactStatus::statusType());

        return $status ? ContactStatus::byValue((string) $status) : null;
    }

    public function getContactStatusHistory(): Collection
    {
        return $this->getStatusHistory(ContactStatus::statusType());
    }
    
    public function location()
    {
        return $this->belongsTo(app('location'));
    }

    public function email()
    {
        return $this->belongsTo(app('email_address'));
    }
    
    public function phone()
    {
        return $this->belongsTo(app('phone'));
    }

    public function responses()
    {
        return $this->hasMany(ContactResponse::class);
    }

    public function user()
    {
        return $this->belongsTo(app('user'));
    }

    public function notes()
    {
        return $this->morphMany(app('note'), 'noteable');
    }
}
