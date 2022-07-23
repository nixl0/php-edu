<?php

namespace Nilixin\Edu;

use BadMethodCallException;
use Nilixin\Edu\debug\Debug;
use Nilixin\Edu\Validation;
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



    /**
     * Проверяет свойства на определенность и пустоту
     *
     * Возвращает FALSE, если хотя бы одно из свойств не определено или пустое, иначе TRUE.
     * Лучше использовать как часть метода validate(), который определяется отдельно
     * в зависимости от соответствующих условий отбора свойств.
     * 
     * // TODO переписать описание
     */
    public function idle()
    {
        $vals = $this->getObjectVals();

        foreach ($vals as $val) {
            if (! isset($val) || empty($val)) {
                return true;
            }
        }

        return false;
    }



    public function validate()
    {
        if (! $this->idle()) {
            if (null == $this->rules()) {
                throw new BadMethodCallException("No rules provided for validation");
            }

            foreach ($this->rules() as $attr => $rules) {
                foreach ($rules as $rule => $val) {
                    switch ($rule) {
                        
                        // REGEX
                        case "regex":
                            if ($val == "plain") {
                                if (! Validation::regexPlain($this->{$attr})) {
                                    throw new InvalidCredentialsException("Unvalid regex plain");
                                }
                            }
                            else {
                                throw new InvalidCredentialsException("Undefined regex value");
                            }
                            break;

                        // SIZE
                        case "size":
                            // проверка на то, что определены границы размера
                            if (! isset($val[0]) || empty($val[0]) || ! isset($val[1]) || empty($val[1])) {
                                throw new InvalidCredentialsException("Undefined size values");
                            }

                            if (! Validation::size($this->{$attr}, $val[0], $val[1])) {
                                throw new InvalidCredentialsException("Unvalid size");
                            }
                            break;

                        // FILTER
                        case "filter":
                            if ($val == "email") {
                                if (! Validation::filterEmail($this->{$attr})) {
                                    throw new InvalidCredentialsException("Unvalid filter email");
                                }
                            }
                            else {
                                throw new InvalidCredentialsException("Undefined filter value");
                            }
                            break;
                        
                        default:
                            throw new InvalidCredentialsException("Undefined validation rules");
                            break;
                    }
                }
            }

            return true;
        }
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