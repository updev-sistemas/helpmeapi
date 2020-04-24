<?php


namespace App\Repository\Contract;


interface IContract
{
    public function save(entity $entity);
    public function delete(entity $entity);
    public function find(entity $id);
    public function list();
    public function query();
}
