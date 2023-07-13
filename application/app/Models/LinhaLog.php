<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Ramsey\Uuid\Uuid;

class LinhaLog extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'log_id', 'error_text'];

    protected static function booted()
    {
        static::creating(fn(LinhaLog $linhaLog) => $linhaLog->id = Uuid::uuid4());
    }

    public function log(): BelongsTo
    {
        return $this->belongsTo(Log::class);
    }

    public function activeTokens(): BelongsTo
    {
        return $this->belongsTo(ActiveToken::class);
    }
}
