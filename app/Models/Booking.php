<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = ['field_id', 'user_id', 'date', 'start_time', 'end_time'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the field that owns the booking.
     */
    public function field()
    {
        return $this->belongsTo(Field::class);
    }
}
