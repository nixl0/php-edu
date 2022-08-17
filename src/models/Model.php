<?php

namespace Nilixin\Edu\models;

use Exception;
use Nilixin\Edu\db\Db;

abstract class Model
{
    public abstract function table();

    public function dbo()
    {
        return Db::class;
    }

    public function selectAll($condition, $expression = "*")
    {
        if (empty($condition) || empty($expression)) {
            throw new Exception("Empty condition or expression when selecting");
        }

        return $this->dbo()::select($expression)
            ->from($this->table())
            ->where($condition)
            ->fetchAll();
    }

    public function selectOne($condition, $expression = "*")
    {
        if (empty($condition) || empty($expression)) {
            throw new Exception("Empty condition or expression when selecting");
        }

        return $this->dbo()::select($expression)
            ->from($this->table())
            ->where($condition)
            ->fetch();
    }

    public function add($dto)
    {
        if (empty($dto)) {
            throw new Exception("Empty dbo provided");
        }

        // TODO валидация
        // TODO в валидацию встроить и проверку на пустоту

        // окружение значений пользователя одинарными кавычками
        array_walk($dto, function (&$value) {
            $value = "'" . "$value" . "'";
        });

        return $this->dbo()::insert($this->table(), implode(", ", array_keys(get_object_vars($dto))), implode(", ", array_values(get_object_vars($dto))))
            ->getQuery();
    }

    public function edit($dto)
    {
        // TODO валидация по примеру метода add()

        // окружение значений пользователя одинарными кавычками
        array_walk($dto, function (&$value) {
            $value = "'" . "$value" . "'";
        });

        // конкатенация атрибутов и их значений
        $data = "";
        $isFirst = true;
        foreach (array_keys(get_object_vars($dto)) as $field) {
            if ($isFirst) {
                $data .= "$field = " . $dto->$field;
                $isFirst = false;
            } else {
                $data .= ", $field = " . $dto->$field;
            }
        }

        return $this->dbo()::update($this->table(), $data)
            ->where("id = $dto->id")
            ->getQuery();
    }

    public function delete($dto)
    {
        return $this->dbo()::delete($this->table())
            ->where("id = $dto->id")
            ->execute();
    }
}