<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class BasketItem extends Model
{
    use SoftDeletes;

    public function baskets(): BelongsTo
    {
        return $this->belongsTo(Basket::class);
    }
}
