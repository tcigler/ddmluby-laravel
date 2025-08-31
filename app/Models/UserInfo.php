<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UserInfo extends Model {
    use HasFactory;

    protected $table = 'user_info';

    public function eventBooking(): HasMany {
        return $this->hasMany(EventBooking::class);
    }

    protected $fillable = [
        'name',
        'email',
        'phone',
        'note',
    ];
}
