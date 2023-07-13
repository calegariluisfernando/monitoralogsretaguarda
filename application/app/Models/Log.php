<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Log extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = ['data'];

    public function linhas(): HasMany
    {
        return $this->hasMany(LinhaLog::class);
    }
}
