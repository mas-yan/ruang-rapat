<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ruangan extends Model
{
    protected $guarded = ['id'];
    use HasFactory;

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function nextBooking()
    {
        return $this->hasOne(Booking::class)->where('mulai', '>', now())->orderBy('mulai', 'asc');
    }
}
