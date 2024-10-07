<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Booking extends Model
{
    protected $guarded = ['id'];
    use HasFactory;

    public function ruangan(): BelongsTo
    {
        return $this->belongsTo(Ruangan::class);
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
