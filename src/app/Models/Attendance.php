<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeDateSearch($query, $date)
    {
        if (!empty($date)) {
            $query->where('date', '=', $date);
        }
    }

    public function scopeUserSearch($query, $user)
    {
        if (!empty($user)) {
            $query->where('user_id', '=', $user);
        }
    }
}
