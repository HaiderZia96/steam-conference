<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Glimpse extends Model
{
    use HasFactory, LogsActivity;
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            //Customizing the log name
            ->useLogName('Glimpse')
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
        'title','image','department_id','glimpse_category_id','glimpse_year_id','glimpse_day_id','created_by','updated_by',
    ];

    public function departments()
    {
        return $this->belongsTo(Department::class,'department_id');
    }

    public function glimpseCategories()
    {
        return $this->belongsTo(GlimpseCategory::class,'glimpse_category_id');
    }

    public function glimpseYears()
    {
        return $this->belongsTo(GlimpseYear::class,'glimpse_year_id');
    }

    public function glimpseDays()
    {
        return $this->belongsTo(GlimpseDay::class,'glimpse_day_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
