<?php

namespace App\Entities;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use SoftDeletes;

    protected $table = 'projects';

    protected $primaryKey = 'id';

    protected $fillable = ['name','initials','description','supervisor_id','enterprise_id','status_id','image'];

    protected $casts = [
        'created_at'=>'datetime',
        'updated_at'=>'datetime',
        'deleted_at'=>'datetime'
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }

    public function enterprise()
    {
        return $this->belongsTo(Enterprise::class,'enterprise_id')->withDefault(function() { return new Enterprise();});
    }

    public function supervisor()
    {
        return $this->belongsTo(User::class,'supervisor_id')->withDefault(function(){ return new User(); });
    }
    public function status()
    {
        return $this->belongsTo(EnterpriseStatus::class,'status_id')->withDefault(function(){return new EnterpriseStatus();});
    }

    public function toArray()
    {
        return [
            'id'=>$this->id,
            'name'=>$this->name,
            'initials'=>$this->initials,
            'description'=>$this->description,
            'supervisor'=>$this->supervisor->toArray() ?? [],
            'enterprise'=>$this->enterprise->toArray() ?? [],
            'status'=>$this->status->toArray() ?? [],
            'image'=>$this->image
        ];
    }
}
