<?php


namespace App\Entities;


use Illuminate\Database\Eloquent\Model;

class UserType extends Model
{
    public $timestamps = false;
    protected $table = 'view_paper_users';
    protected $primaryKey = 'id';
    protected $fillable = ["name","description"];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }
}
