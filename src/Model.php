<?php

namespace Nilixin\Edu;

use BadMethodCallException;
use Nilixin\Edu\debug\Debug;
use Nilixin\Edu\db\Db;
use Nilixin\Edu\exception\InvalidCredentialsException;

abstract class Model
{
    // Базовые константы
    
    protected $id;
    
    public function dbo()
    {
        return Db::init();
    }

    public abstract function table();
    public abstract function fields();
    public abstract function validator();
    public abstract function rules();



    // Магические методы
    
    public function __get($property)
    {
        if (property_exists($this, $property)) {
            return $this->$property;
        }
    }
    
    public function __set($property, $value)
    {
        if (property_exists($this, $property)) {
            $this->$property = $value;
        }

        return $this;
    }
    
    public function __toString()
    {
        $properties = get_object_vars($this);

        $string = "";
        $isFirst = true;
        foreach ($properties as $key => $property) {
            if ($isFirst) {
                $string .= "($key): $property";
                $isFirst = false;
            } else {
                $string .= ", ($key): $property";
            }
        }

        return $string;
    }



    public function getObjectVals()
    {
        $vals = array();

        foreach ($this->fields() as $field) {
            $vals[$field] = $this->{$field};
        }

        return $vals;
    }



    public function validate()
    {
        if (empty($this->rules()) || empty($this->fields())) {
            return false;
        }

        foreach ($this->fields() as $field) {
            $keyExists = null;
            $value = null;
            $details = null;

            // исключение, если среди деталей (правил одного атрибута) нет типа
            try {
                $value = $this->{$field};
                $details = $this->rules()[$field];
                $keyExists = array_key_exists("type", $details);
            } catch (\Throwable) {
                throw new BadMethodCallException("Rules syntax error");
            }

            // исключение, если валидация не пройдена успешно
            if ($keyExists) {
                if (! empty($this->validator())) {
                    throw new BadMethodCallException("No validator provided");
                }

                $this->validator()::check($value, $details);
            }
            else {
                throw new BadMethodCallException("No type provided");
            }
        }

        return true;
    }



    /**
     * Автоматическое присвоение значений переменным.
     *
     * Отбирает запись по указанному условию отбора из БД, затем автоматически присваивает значение переменным модели.
     * Для корректной работы требуется чтобы названия полей БД и свойств модели совпадали.
     *
     * @param string $condition Условие, которое определяет запись, обычно id, хотя может быть абсолютно любым полем.
     * Примеры: "id = 2", "username = 'Иван'".
     * @param string $expression Выражение, которое требуется вернуть. По умолчанию "*". Изменять не желательно.
     */
    public function selectOne($condition, $expression = "*")
    {
        $object = $this->dbo()::select($expression)
            ->from($this->table())
            ->where($condition)
            ->getObject();

        // значение key
        $this->id = $object->id;

        // остальные значения
        foreach ($this->fields() as $field) {
            $this->{$field} = $object->{$field};
        }
    }



    /**
     * Добавление новой записи в таблицу БД.
     *
     * Все свойства модели должны быть заполнены.
     */
    public function add()
    {
        if (!$this->validate()) {
            throw new BadMethodCallException("Bad validation");
        }

        $vals = $this->getObjectVals();

        // окружение значений пользователя одинарными кавычками
        array_walk($vals, function (&$value) {
            $value = "'" . "$value" . "'";
        });

        Debug::dd("STOP");

        $this->dbo()::insert($this->table(), implode(", ", $this->fields()), implode(", ", $vals))
            ->getStatement();
    }



    public function edit()
    {
        if (!$this->validate()) {
            throw new BadMethodCallException("Bad validation");
        }

        $vals = $this->getObjectVals();

        // окружение значений пользователя одинарными кавычками
        array_walk($vals, function (&$value) {
            $value = "'" . "$value" . "'";
        });

        // конкатенация атрибутов и их значений
        $data = "";
        $isFirst = true;
        foreach ($this->fields() as $field) {
            if ($isFirst) {
                $data .= "$field = $vals[$field]";
                $isFirst = false;
            } else {
                $data .= ", $field = $vals[$field]";
            }
        }

        $this->dbo()::update($this->table(), $data)
            ->where("id = $this->id")
            ->getStatement();
    }



    public function delete()
    {
        $this->dbo()::delete($this->table())
            ->where("id = $this->id")
            ->getStatement();
    }
}