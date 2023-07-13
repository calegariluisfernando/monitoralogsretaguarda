<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class ActiveToken extends Model
{
    use HasFactory;
    protected $table = 'active_token';
    protected $fillable = ['user_id', 'token'];

    public static function booted()
    {
        static::creating(fn(ActiveToken $activeToken) => $activeToken->id = Uuid::uuid4());
    }
}
