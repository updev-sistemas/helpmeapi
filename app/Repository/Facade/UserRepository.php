<?php


namespace App\Repository\Facade;

use App\Repository\Contract\IContract;
use App\Repository\Contract\IUserRepository;
use App\User;

class UserRepository extends DefaultRepository implements IContract, IUserRepository
{
    public function register($entity)
    {
        try {
            if(!($entity instanceof User))
                throw new \Exception('Objeto passado não é de um Usuário');

            $saved = $entity->save();
            if($saved)
                return $entity;
            return null;
        } catch (\Exception $e) {
            logger($e->getMessage(),["repository"=>"user","method"=>"register"]);
            return null;
        }
    }

    public function update($entity)
    {
        try {
            if(!($entity instanceof User))
                throw new \Exception('Objeto passado não é de um Usuário');

            $updated = $entity->save();
            if($updated)
                return $entity;
            return null;
        } catch (\Exception $e) {
            logger($e->getMessage(),["repository"=>"user","method"=>"update"]);
            return false;
        }
    }

    public function changeStatus($entity,$status)
    {
        try {
            if(!($entity instanceof User))
                throw new \Exception('Objeto passado não é de um Usuário');

        } catch (\Exception $e) {
            logger($e->getMessage(),["repository"=>"user","method"=>"changeStatus"]);
            return false;
        }
    }

    public function changePaper($entity, $paper)
    {
        try {
            if(!($entity instanceof User))
                throw new \Exception('Objeto passado não é de um Usuário');

        } catch (\Exception $e) {
            logger($e->getMessage(),["repository"=>"user","method"=>"changePaper"]);
            return false;
        }
    }
}
