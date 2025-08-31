<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model {
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'location',
        'program',
        'start',
        'end',
        'show_from',
        'reservation_open',
    ];

    public function timeSlots(): HasMany {
        return $this->hasMany(EventTimeSlot::class);
    }

    protected function casts(): array {
        return [
            'start' => 'datetime',
            'end' => 'datetime',
            'show_from' => 'datetime',
            'reservation_open' => 'boolean',
        ];
    }
}
