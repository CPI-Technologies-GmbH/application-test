<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeTrackingFollowing extends Model
{
    use HasFactory;

    protected $fillable = [
        'start_date',
        'end_date',
    ];

    public function project() {
        return $this->hasOne(Projects::class);
    }
}
