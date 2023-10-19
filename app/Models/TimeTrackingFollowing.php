<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeTrackingFollowing extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'start_time',
        'end_time',
    ];

    protected $casts = [
        'start_time' => 'date',
        'end_time' => 'date',
    ];
}
