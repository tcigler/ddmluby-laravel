<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
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

    public function eventTimeSlot(): BelongsTo {
        return $this->belongsTo(EventTimeSlot::class);
    }

    public function userInfo(): HasOne {
        return $this->hasOne(UserInfo::class);
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
