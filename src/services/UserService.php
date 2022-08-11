<?php

namespace Nilixin\Edu\services;

use BadMethodCallException;
use Exception;
use Nilixin\Edu\debug\Debug;
use Nilixin\Edu\dtos\UserDto;
use Nilixin\Edu\models\UserModel;

class UserService
{
    public static $instance = null;

    private function __construct(
        public $model
    )
    { }

    public static function init($model = new UserModel)
    {
        if (! self::$instance) {
            self::$instance = new UserService($model);
        }

        return self::$instance;
    }

    public function selectAll($condition, $expression = '*')
    {
        if (empty($condition) || empty($expression)) {
            throw new Exception('Empty condition or expression when selecting');
        }

        return $this->model->dbo()::select($expression)
            ->from($this->model->table())
            ->where($condition)
            ->fetchAll();
    }

    public function selectOne($condition, $expression = '*')
    {
        if (empty($condition) || empty($expression)) {
            throw new Exception('Empty condition or expression when selecting');
        }

        return $this->model->dbo()::select($expression)
            ->from($this->model->table())
            ->where($condition)
            ->fetch();
    }

    public function add($dto)
    {
        if (empty($dto)) {
            throw new Exception('Empty dbo provided');
        }
        
        // TODO валидация
        // TODO в валидацию встроить и проверку на пустоту

        // окружение значений пользователя одинарными кавычками
        array_walk($dto, function (&$value) {
            $value = "'" . "$value" . "'";
        });

        return $this->model->dbo()::insert($this->model->table(), implode(", ", $dto->fields()['necessary']), implode(", ", $dto->toArray()))
            ->execute();
    }

    public function edit($dto)
    {
        // TODO валидация по примеру метода add()

        // окружение значений пользователя одинарными кавычками
        array_walk($dto, function (&$value) {
            $value = "'" . "$value" . "'";
        });

        // конкатенация атрибутов и их значений
        $data = '';
        $isFirst = true;
        foreach ($dto->fields()['necessary'] as $field) {
            Debug::val($field);
            if ($isFirst) {
                $data .= "$field = " . $dto->$field;
                $isFirst = false;
            } else {
                $data .= ", $field = " . $dto->$field;
            }
        }

        return $this->model->dbo()::update($this->model->table(), $data)
            ->where("id = $dto->id")
            ->execute();
    }

    public function delete($dto)
    {
        return $this->model->dbo()::delete($this->model->table())
            ->where("id = $dto->id")
            ->execute();
    }
}