<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Publication extends Model
{
    use HasFactory, LogsActivity;
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            //Customizing the log name
            ->useLogName('Publication')
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
        'title','author','doc_file','publication_type_id','department_id','created_by','updated_by',
    ];

    public function publicationTypes()
    {
        return $this->belongsTo(PublicationType::class,'publication_type_id');
    }
    public function departments()
    {
        return $this->belongsTo(Department::class,'department_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
