<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class User extends Authenticatable  implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;
    protected $primaryKey = 'id';
    public $incrementing = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'fname',
        'lname',
        'email',
        'country_code',
        'phone',
        'photo',
        'otp',
        'is_verified',
        'status',
        'password',
        'JWT_token',
        'is_social',
        'social_id',
        'Social_type',
        'is_mobile_verified'

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'otp',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'id' => 'string',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = (string) Str::uuid();
        });
    }

    public function userAddress(): HasMany
    {
        return $this->hasMany(UserAddress::class);
    }

    public function visaEnquiries(): HasMany
    {
        return $this->hasMany(VisaEnquiry::class);
    }
    
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}