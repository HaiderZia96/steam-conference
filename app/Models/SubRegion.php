<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class SubRegion extends Model
{
    use HasFactory,LogsActivity;

    /**
     * Activity Log
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            //Customizing the log name
            ->useLogName('SubRegion')
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
        'name','description','status','region_id','created_by','updated_by','deleted_by'
    ];


    /**
     * Relationship
     *
     */
    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function regions(){
        return $this->belongsTo(Region::class,'region_id');
    }

    public function countries()
    {
        return $this->hasMany(Country::class, 'sub_region_id');
    }
}
