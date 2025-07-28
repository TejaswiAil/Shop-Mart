<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use SoftDeletes;
    use HasFactory;

    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

//    /**
//     * The accessors to append to the model's array form.
//     *
//     * @var array<int, string>
//     */
//    protected $appends = [
//        'profile_photo_url',
//    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function addresses():BelongsToMany
    {
        return $this->belongsToMany(Address::class)
            ->using(AddressUser::class)
            ->withPivot('valid_from', 'valid_to');
    }

    //Check this
    public function activeAddresses():BelongsToMany
    {
        return $this->belongsToMany(Address::class)
            ->using(AddressUser::class)
            ->wherePivot('valid_from', '<=' , 'today' )
            ->where(function($query) {
                $query->where('valid_to', '>=', today())
                    ->orWhereNull('valid_to');
            })
            ->withPivot('valid_from', 'valid_to');
    }
}
