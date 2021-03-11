<?php

declare(strict_types=1);

namespace Tipoff\Forms\Models;

use Assert\Assert;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Tipoff\Support\Models\BaseModel;
use Tipoff\Support\Traits\HasPackageFactory;

class Contact extends BaseModel
{
    use HasPackageFactory;
    use SoftDeletes;

    protected $casts = [
        'emailed_at' => 'datetime',
        'requested_date' => 'date',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($contact) {
            Assert::lazy()
                ->that($contact->location_id)->notEmpty('A contact must be made to a location.')
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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(app('user'));
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function location()
    {
        return $this->belongsTo(app('location'));
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function notes()
    {
        return $this->morphMany(app('note'), 'noteable');
    }
}
