<?php

declare(strict_types=1);

namespace Tipoff\Forms\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Tipoff\Support\Models\BaseModel;
use Tipoff\Support\Traits\HasPackageFactory;

class ContactResponse extends BaseModel
{
    use HasPackageFactory;
    use SoftDeletes;

    const UPDATED_AT = null;

    protected $casts = [
	    'fields' => 'array',
	    'emailed_at' => 'datetime',
	];

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }
}
