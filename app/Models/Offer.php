<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Offer extends Model
{
    use SoftDeletes;

    protected function casts(): array
    {
        return [
            'valid_from' => 'date:Y-m-d',
            'valid_to' => 'date:Y-m-d',
        ];
    }

    #[Scope]
    protected function active(Builder $query): void
    {
        $query->where('valid_from', '<=', today())
            ->where(function (Builder $query) {
                $query->where('valid_to', '>=', today())
                    ->orWhereNull('valid_to');
            });
    }
}
