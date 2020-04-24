<?php


namespace App\Entities;


use Illuminate\Database\Eloquent\Model;

class UserStatus extends Model
{
    public $timestamps = false;
    protected $table = 'view_user_status';
    protected $primaryKey = 'id';
    protected $fillable = ["name"];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }
}
