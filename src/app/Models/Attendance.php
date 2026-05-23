<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Attendance extends Model
{
    /** @use HasFactory<\Database\Factories\AttendanceFactory> */
    use HasFactory;

    // 勤務状態定数
    const ATTENDANCE_STATE_BEFORE_WORK = 0;     // 勤務外
    const ATTENDANCE_STATE_WORKING = 1;         // 勤務中
    const ATTENDANCE_STATE_BREAK_TIME = 2;      // 休憩中
    const ATTENDANCE_STATE_FINISH_WORK = 3;     // 退勤済

    protected $fillable = [
        'user_id',
        'punch_in_at',
        'punch_out_at',
        'remarks',
    ];

    protected $casts = [
        'punch_in_at' => 'datetime',
        'punch_out_at' => 'datetime',
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
        return $this->hasMany('App\Models\BreakTime');
    }

    public function latestBreakTime()
    {
        return $this->hasOne(BreakTime::class)->ofMany('id', 'max');
    }

    public function getAttendanceState()
    {
        if (new Carbon($this->punch_in_at)->toDateString() === Carbon::now()->format('Y-m-d')) {
            if (!empty($this->punch_out_at)) {
                return self::ATTENDANCE_STATE_FINISH_WORK;
            } else {
                if(!empty($this->latestBreakTime) && empty($this->latestBreakTime['end_break_at'])) {
                    return self::ATTENDANCE_STATE_BREAK_TIME;
                } else {
                    return self::ATTENDANCE_STATE_WORKING;
                }
            }
        } else {
            return self::ATTENDANCE_STATE_BEFORE_WORK;
        }
    }

    public function totalBreakTimeMinute()
    {
        $totalMinute = 0;
        foreach ($this->breakTimes as $breakTime) {
            $startBreakAt = $breakTime['start_break_at'];
            if (empty($breakTime['end_break_at'])) {
                return null;
            }
            $endBreakAt = $breakTime['end_break_at'];
            $difference = $startBreakAt->diffInMinutes($endBreakAt);
            $totalMinute += $difference;
        }
        return $totalMinute;
    }

    public function totalWorkTimeMinute()
    {
        if (empty($this->punch_out_at)) {
            return null;
        }
        $totalBreakMinute = $this->totalBreakTimeMinute();
        $workMinute = $this->punch_in_at->diffInMinutes($this->punch_out_at);
        $totalWorkMinute = $workMinute - $totalBreakMinute;
        return $totalWorkMinute;
    }
}