<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RevisionBreakTime extends Model
{
    /** @use HasFactory<\Database\Factories\RevisionBreakTimeFactory> */
    use HasFactory;

    protected $fillable = [
        'revision_attendance_id',
        'start_break_at',
        'end_break_at',
    ];

    protected $casts = [
        'start_break_at' => 'datetime',
        'end_break_at' => 'datetime',
    ];

    public function revisionAttendance()
    {
        return $this->belongsTo('App\Models\RevisionAttendance');
    }
}
