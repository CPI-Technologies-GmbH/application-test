<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\TimeTrackingFollowing;

// TODO: consider renaming to Project
class Projects extends Model
{
    use HasFactory;

    protected $table = 'projects';

    protected $fillable = [
        'name',
        'description',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function timeTrackingFollowings(): HasMany
    {
        return $this->hasMany(TimeTrackingFollowing::class, 'project_id');
    }
}
