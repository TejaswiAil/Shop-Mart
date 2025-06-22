<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends Model
{
    use SoftDeletes;

    public function users():BelongsToMany
    {
        return $this->belongsToMany(User::class)
            ->using(AddressUser::class)
            ->withPivot('valid_from', 'valid_to');
    }
}
