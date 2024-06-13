<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class City extends Model
{
    use HasFactory,LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            //Customizing the log name
            ->useLogName('City')
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
        'name','description','postal_code','longitude','latitude','country_id','state_id','status','created_by','updated_by','deleted_by'
    ];


    public function user_registrations()
    {
        return $this->hasMany(UserRegistration::class,'city_id');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function countries()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function states()
    {
        return $this->belongsTo(State::class, 'state_id');
    }
}
