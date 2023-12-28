<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeTracking extends Model
{
    use HasFactory;

    protected $table = 'timetracking';
    protected $fillable = [
        'project_id',
        'user_id',
        'start_time',
        'end_time',
        'description',
    ];

    public function project()
    {
        return $this->belongsTo(Projects::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function isTracked()
    {
        return $this->tracked;
    }
}
