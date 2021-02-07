<?php namespace Tipoff\Forms\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Tipoff\Support\Models\BaseModel;
use Tipoff\Support\Traits\HasPackageFactory;

class Contact extends BaseModel
{
    use HasPackageFactory;
    use SoftDeletes;

    protected $guarded = ['id'];

    protected $casts = [
        'emailed_at' => 'datetime',
        'requested_date' => 'date',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($contact) {
            if (empty($contact->user_id)) {
                throw new \Exception('A contact must be made by a user.');
            }
            if (empty($contact->location_id)) {
                throw new \Exception('A contact must be made to a location.');
            }
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
        return $this->belongsTo(config('tipoff.model_class.user'));
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function location()
    {
        return $this->belongsTo(config('tipoff.model_class.location'));
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function notes()
    {
        return $this->morphMany(config('tipoff.model_class.note'), 'noteable');
    }
}
