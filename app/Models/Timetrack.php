<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Timetrack extends Model
{
    use HasFactory;

    protected $table = 'timetrack';

    protected $fillable = [
        'user_id',
        'project_id',
        'start_time',
        'end_time'
    ];
}
