<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventAttendee extends Model {
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'event_booking_id',
        'note',
        'code',
    ];

    public function eventBooking(): BelongsTo {
        return $this->belongsTo(EventBooking::class);
    }
}
