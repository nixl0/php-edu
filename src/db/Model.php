<?php

namespace Nilixin\Edu\db;

use Nilixin\Edu\debug\Debug;
use Nilixin\Edu\db\Validation;

abstract class Model
{
    // Базовые константы


    
    protected $id;



    public function dbo()
    {
        return Db::init();
    }



    public abstract function table();



    public function key()
    {
        return "id";
    }



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
            if (! isset($val) && empty($val)) {
                return true;
            }
        }

        return false;
    }



    public function validate()
    {
        // TODO понасоздавать кучу исключений для вывода ошибок

        if (! $this->idle()) {
            if (null == $this->rules()) {
                return;
            }

            foreach ($this->rules() as $attr => $rules) {
                // Debug::prn($attr);
                foreach ($rules as $rule => $val) {
                    // Debug::prn("$rule : $val");
                    
                    switch ($rule) {
                        
                        // REGEX
                        case 'regex':
                            if ($val == 'plain') {
                                if (! Validation::regexPlain($this->{$attr})) {
                                    Debug::prn("bad validation regex plain");
                                    return false;
                                }
                            }
                            else {
                                Debug::prn("bad validation regex plain empty");
                                return false;
                            }
                            break;

                        // SIZE
                        case 'size':
                            // проверка на то, что определены границы размера
                            if (! isset($val[0]) || empty($val[0]) || ! isset($val[1]) || empty($val[1])) {
                                Debug::prn("bad validation size borders");
                                return false;
                            }

                            if (! Validation::size($this->{$attr}, $val[0], $val[1])) {
                                Debug::prn("bad validation size");
                                return false;
                            }
                            break;

                        // FILTER
                        case 'filter':
                            if ($val == 'email') {
                                if (! Validation::filterEmail($this->{$attr})) {
                                    Debug::prn("bad validation email");
                                    return false;
                                }
                            }
                            else {
                                Debug::prn("bad validation email empty");
                                return false;
                            }
                            break;
                        
                        default:
                            Debug::prn("entered default");
                            return false;
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
        $this->{$this->key()} = $object->{$this->key()};

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
            echo "bad validation";
            return;
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
            echo "bad validation";
            return;
        }
        Debug::prn("good validation");

        $vals = $this->getObjectVals();

        Debug::prn($vals);

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

        $id = $this->{$this->key()};

        $this->dbo()::update($this->table(), $data)
            ->where("id = $id")
            ->getStatement();
    }



    public function delete()
    {
        $id = $this->{$this->key()};

        $this->dbo()::delete($this->table())
            ->where("id = $id")
            ->getStatement();
    }
}