<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Str;

class ZiyaratEnquiry extends Model
{
    use HasApiTokens, HasFactory, SoftDeletes;

    protected $primaryKey = 'id';
    public $incrementing = false;

    protected $fillable = [
        'country',
        'ziyarat_package',
        'date',
        'email',
        'name',
        'price',
        'mobile',
        'status',
        'travellers',

    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $casts = [
        'id' => 'string', // Cast the UUID as a string
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = Str::uuid()->toString();
        });
    }

    

}
