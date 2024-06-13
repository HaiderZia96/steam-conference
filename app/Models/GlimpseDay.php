<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class GlimpseDay extends Model
{
    use HasFactory, LogsActivity;
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            //Customizing the log name
            ->useLogName('GlimpseDay')
            //Log changes to all the $fillable
            ->logFillable()
            //Customizing the description
            ->setDescriptionForEvent(fn(string $eventName) => "{$eventName}")
            //Logging only the changed attributes
            ->logOnlyDirty()
            //Prevent save logs items that have no changed attribute
            ->dontSubmitEmptyLogs();
    }

    protected $fillable = [
        'day','date','glimpse_year_id','created_by','updated_by',
    ];

    public function glimpseYears()
    {
        return $this->belongsTo(GlimpseYear::class,'glimpse_year_id');
    }

    public function glimpses()
    {
        return $this->hasMany(Glimpse::class,'glimpse_day_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
