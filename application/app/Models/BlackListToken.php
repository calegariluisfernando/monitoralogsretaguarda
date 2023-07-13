<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class BlackListToken extends Model
{
    use HasFactory;
    protected $table = 'black_list_token';
    protected $fillable = ['token'];

    protected static function booted()
    {
        static::creating(fn(BlackListToken $blackListToken) => $blackListToken->id = Uuid::uuid4());
    }
}
