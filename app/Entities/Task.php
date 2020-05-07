<?php

namespace App\Entities;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use PhpParser\Comment;

class Task extends Model
{
    use SoftDeletes;

    protected $table = 'tasks';

    protected $primaryKey = 'id';

    protected $fillable = ['ticket_number','title','customer_report','technical_report','expected_time_hours',
        'expected_time_minute','hour_worked_hours','hour_worked_minute','started_at','finish_at','reporter_id',
        'project_id','enterprise_id','technician_id','supervisor_id','priority','status_id','type_id'
    ];

    protected $casts = [
        'started_at'=>'datetime',
        'finish_at'=>'datetime',
        'priority'=>'datetime',
        'created_at'=>'datetime',
        'updated_at'=>'datetime',
        'deleted_at'=>'datetime'
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }

    public function type()
    {
        return $this->belongsTo(null,'type_id');
    }

    public function status()
    {
        return $this->belongsTo(null,'status_id');
    }

    public function enterprise()
    {
        return $this->belongsTo(Enterprise::class,'enterprise_id');
    }

    public function project()
    {
        return $this->belongsTo(Project::class,'project_id');
    }

    public function customer()
    {
        return $this->belongsTo(User::class,'customer_report');
    }

    public function supervisor()
    {
        return $this->belongsTo(User::class,'supervisor_id');
    }

    public function technician()
    {
        return $this->belongsTo(User::class,'technician_id');
    }

    public function comments()
    {
        return $this->hasMany(TaskComment::class,'task_id')->orderBy('created_at')->get();
    }
}
