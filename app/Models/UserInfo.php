<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;

class UserInfo extends Model {
    use HasFactory;

    protected $table = 'user_info';

    protected $appends = ['is_verified'];

    protected $dates = ['verified_at'];

    public function eventBooking(): HasOne {
        return $this->hasOne(EventBooking::class);
    }

    protected $fillable = [
        'name',
        'email',
        'phone',
        'note',
    ];

    public function getIsVerifiedAttribute(): bool {
        return !isset($this->verification_code) && Carbon::now()->isAfter($this->verified_at);
    }

    protected static function booted(): void {
        static::creating(function (UserInfo $b) {
            if (empty($b->verification_code) && empty($b->verified_at)) {
                $b->verification_code = Str::ulid()->toString();
            }
        });
    }
}
