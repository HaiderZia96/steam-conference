<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CandidateAttendance extends Model
{
    use HasFactory;
    protected $fillable = [
        'conference_year_id',
        'candidate_id',
        'in_out',
        'attendance_mark_by',
    ];
    public function scanBy(){
        return $this->belongsTo(User::class,'attendance_mark_by');
    }
    public function candidate(){
        return $this->belongsTo(UserRegistration::class,'candidate_id');
    }
}
