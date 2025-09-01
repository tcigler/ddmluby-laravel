<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Support\Str;

class EventBooking extends Model {
    use HasFactory;

    public $timestamps = true;

    protected $fillable = [
        'uuid',
        'event_time_slot_id',
        'user_info_id',
        'note',
    ];

    protected $withCount = ['attendees'];

    public function eventTimeSlot(): BelongsTo {
        return $this->belongsTo(EventTimeSlot::class);
    }

    public function event(): HasOneThrough {
        return $this->hasOneThrough(Event::class, EventTimeSlot::class,
            "id", "id", "event_time_slot_id", "event_id");
    }

    public function userInfo(): BelongsTo {
        return $this->belongsTo(UserInfo::class);
    }

    public function attendees(): HasMany {
        return $this->hasMany(EventAttendee::class);
    }

    protected function casts(): array {
        return [
            'paid_at' => 'datetime',
            'expire_at' => 'datetime',
        ];
    }

    protected static function booted(): void {
        static::creating(function (EventBooking $b) {
            if (empty($b->uuid)) {
                $b->uuid = Str::uuid()->toString();
            }
        });
    }
}
