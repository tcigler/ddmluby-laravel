<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model {
    use HasFactory, Sluggable, SluggableScopeHelpers;

    protected $fillable = [
        'title',
        'description',
        'location',
        'program',
        'start',
        'end',
        'show_from',
        'registration_from',
        'registration_open',
    ];

    public function timeSlots(): HasMany {
        return $this->hasMany(EventTimeSlot::class);
    }

    protected $dates = [
        "start",
        "end",
        "show_from",
        "registration_from"
    ];

    protected function casts(): array {
        return [
            'registration_open' => 'boolean',
        ];
    }

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
}
