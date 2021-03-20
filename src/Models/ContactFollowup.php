<?php

declare(strict_types=1);

namespace Tipoff\Forms\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Tipoff\Support\Models\BaseModel;
use Tipoff\Support\Traits\HasPackageFactory;

class ContactFollowup extends BaseModel
{
    use HasPackageFactory;
    use SoftDeletes;

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }
}
