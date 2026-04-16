<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BreakTime extends Model
{
    /** @use HasFactory<\Database\Factories\BreakTimeFactory> */
    use HasFactory;

    protected $fillable = [
        'attendance_id',
        'start_break_at',
        'end_break_at',
    ];

    public function attendance()
    {
        return $this->belongsTo('App\Models\Attendance');
    }
}
