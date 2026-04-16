<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    /** @use HasFactory<\Database\Factories\AttendanceFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'punch_in_at',
        'punch_out_at',
        'remarks',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function revisionAttendances()
    {
        return $this->hasMany('App\Models\RevisionAttendance');
    }

    public function breakTimes()
    {
        return $this->hadMany('App\Models\BreakTime');
    }
}
