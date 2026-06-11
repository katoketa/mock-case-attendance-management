<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RevisionAttendance extends Model
{
    /** @use HasFactory<\Database\Factories\RevisionAttendanceFactory> */
    use HasFactory;

    protected $fillable = [
        'attendance_id',
        'punch_in_at',
        'punch_out_at',
        'is_approval',
        'remarks',
    ];

    protected $casts = [
        'punch_in_at' => 'datetime',
        'punch_out_at' => 'datetime',
        'is_approval' => 'boolean',
    ];

    protected $attributes = [
        'is_approval' => false,
    ];

    public function attendance()
    {
        return $this->belongsTo('App\Models\Attendance');
    }

    public function revisionBreakTimes()
    {
        return $this->hasMany('App\Models\RevisionBreakTime');
    }
}