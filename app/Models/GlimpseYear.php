<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class GlimpseYear extends Model
{
    use HasFactory, LogsActivity;
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            //Customizing the log name
            ->useLogName('GlimpseYear')
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
        'name','year','created_by','updated_by',
    ];

    public function glimpseDays()
    {
        return $this->hasMany(GlimpseDay::class,'glimpse_year_id');
    }
    public function glimpses()
    {
        return $this->hasMany(Glimpse::class,'glimpse_year_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
