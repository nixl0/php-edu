<?php

namespace Nilixin\Edu\models;

use Exception;
use Nilixin\Edu\db\Db;

abstract class Model
{
    abstract public function table();

    abstract public function validator();

    abstract public function rules();

    public function dbo()
    {
        return Db::class;
    }

    public function exists($condition)
    {
        return $this->dbo()::exists($this->table(), $condition);
    }

    public function selectAll($condition, $expression = "*")
    {
        if (empty($condition) or empty($expression)) {
            throw new Exception("Empty condition or expression when selecting");
        }

        return $this->dbo()::select($expression)
            ->from($this->table())
            ->where($condition)
            ->fetchAll();
    }

    public function selectOne($condition, $expression = "*")
    {
        if (empty($condition) or empty($expression)) {
            throw new Exception("Empty condition or expression when selecting");
        }

        // должно возвращать modelDto'шку
        return $this->dbo()::select($expression)
            ->from($this->table())
            ->where($condition)
            ->fetch();
    }

    public function add($dto, $skip = ["id"])
    {
        if (empty($dto)) {
            throw new Exception("Empty dbo provided");
        }

        // валидация
        if ($this->validator()) {
            $this->validator()::validate($dto, $this->rules());
        }

        // окружение значений пользователя одинарными кавычками
        array_walk($dto, function (&$value) {
            $value = "'" . "$value" . "'";
        });

        $addableDto = array();
        foreach ($dto as $key => $value) {
            // переход к следующему полю, если поле определено пропускать
            if (in_array($key, $skip)) continue;
            
            // переход к следующему полю, если поле не было заполнено / пустое
            if ($value == "''") continue;

            $addableDto[$key] = $value;
        }
        $addableDto = (object) $addableDto;

        return $this->dbo()::insert($this->table(), implode(", ", array_keys(get_object_vars($addableDto))), implode(", ", array_values(get_object_vars($addableDto))))
            ->getQuery();
    }

    /**
     * Редактирует данные модели.
     * 
     * Редактирует только те поля, которые были заполнены, а также те, которые НЕ были указаны в параметре $skip.
     * Для корректной работы, методу нужно передавать такой DTO объект, в котором будет содержаться поле id.
     * 
     * @param object $dto DTO объект с данными.
     * @param array $skip Массив, который определяет те поля, которые необходимо пропускать во время редактирования.
     */
    public function edit($dto, $skip = ["id"])
    {
        if (empty($dto)) {
            throw new Exception("Empty dbo provided");
        }

        // валидация
        if ($this->validator()) {
            $this->validator()::validate($dto, $this->rules());
        }

        // окружение значений пользователя одинарными кавычками
        array_walk($dto, function (&$value) {
            $value = "'" . "$value" . "'";
        });

        // конкатенация атрибутов и их значений
        $addableData = "";
        $isFirst = true;
        foreach (array_keys(get_object_vars($dto)) as $field) {
            // переход к следующему полю, если поле определено пропускать
            if (in_array($field, $skip)) continue;

            // переход к следующему полю, если поле не было заполнено / пустое
            if ($dto->$field == "''") continue;

            if ($isFirst) {
                $addableData .= "$field = " . $dto->$field;
                $isFirst = false;
            } else {
                $addableData .= ", $field = " . $dto->$field;
            }
        }

        return $this->dbo()::update($this->table(), $addableData)
            ->where("id = $dto->id")
            ->execute();
    }

    public function delete($dto)
    {
        return $this->dbo()::delete($this->table())
            ->where("id = $dto->id")
            ->execute();
    }
}