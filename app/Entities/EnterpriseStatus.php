<?php


namespace App\Entities;


use Illuminate\Database\Eloquent\Model;

class EnterpriseStatus extends Model
{
    public $timestamps = false;
    protected $table = 'view_enterprise_status';
    protected $primaryKey = 'id';
    protected $fillable = ["name"];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }

    public function toArray()
    {
        return ['id' => $this->id, 'name' => $this->name];
    }
}
