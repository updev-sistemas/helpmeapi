<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Enterprise extends Model
{
    use SoftDeletes;

    protected $table = 'enterprises';
    protected $primaryKey = 'id';
    protected $fillable = ['name', 'image', 'document', 'email', 'phone', 'address_name', 'address_district', 'address_cep', 'address_city', 'address_state_uf', 'subsidiary_id', 'status_id'];
    protected $casts = [
        'created_at'=>'datetime',
        'updated_at'=>'datetime',
        'deleted_at'=>'datetime'
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }

    public function status()
    {
        return $this->belongsTo(EnterpriseStatus::class,'status_id');
    }

    public function toArray()
    {
        return [
            'name'=>$this->name,
            'document'=>$this->document,
            'status'=>$this->status->toArray(),
            'email'=>$this->email,
            'phone'=>$this->phone,
            'address'=>$this->address_name,
            'district'=>$this->address_district,
            'cep'=>$this->address_cep,
            'city'=>$this->address_city,
            'uf'=>$this->address_state_uf,
        ];
    }
}
