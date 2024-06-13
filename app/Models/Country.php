<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Country extends Model
{
    use HasFactory,LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            //Customizing the log name
            ->useLogName('Country')
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
        'name','description','phone_code','capital','native_name','longitude','latitude','iso_2','iso_3','numeric_code','tld','emoji','emoji_u','region_id','currency_id','sub_region_id','status','created_by','updated_by','deleted_by'
    ];

    /**
     * Relationship
     *
     */
    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /** One Country has many regions **/
    public function regions()
    {
        return $this->belongsTo(Region::class, 'region_id');
    }

    /** One Country has many sub-regions **/
    public function subRegions()
    {
        return $this->belongsTo(SubRegion::class, 'sub_region_id');
    }

    /** One Country has many currencies **/
    public function currencies()
    {
        return $this->belongsTo(Currency::class, 'currency_id');
    }

    /** One Country has many states **/
    public function states()
    {
        return $this->HasMany(State::class, 'country_id');
    }

    /** One Country has many cities **/
    public function cities()
    {
        return $this->HasMany(City::class, 'country_id');
    }

    public function user_registrations()
    {
        return $this->hasMany(UserRegistration::class,'country_id');
    }
}
