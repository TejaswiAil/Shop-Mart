<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Image extends Model
{
    use SoftDeletes;
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class)
            ->using(ImageProduct::class);
    }
}
