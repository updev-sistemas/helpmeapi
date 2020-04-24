<?php


namespace App\Repository\Facade;


trait DefaultFunctions
{

    public function save($entity)
    {
        try {
            $save = $entity->save();
            if(!$save)
                return null;
            return $entity;
        } catch (\Exception $e) {
            return null;
        }
    }

    public function delete($entity)
    {
        try {
            return $entity->delete();
        } catch (\Exception $e) {
            return false;
        }
    }

    public function find($id)
    {
        try {
            return entity::find($id);
        } catch (\Exception $e) {
            return null;
        }
    }

    public function list()
    {
        try {
            return entity::all();
        } catch (\Exception $e) {
            return null;
        }
    }

    public function query()
    {
        return entity::query();
    }
}
