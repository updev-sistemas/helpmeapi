<?php


namespace App\Repository\Contract;


interface IUserRepository
{
    public function register($entity);
    public function update($entity);
    public function changeStatus($entity, $status);
    public function changePaper($entity, $paper);
}
