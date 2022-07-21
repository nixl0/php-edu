<?php

namespace Nilixin\Edu\db;

abstract class Model
{
    // Basic constants

    public abstract function table();

    public $keyValue;
    public function key()
    {
        return "id";
    }

    public abstract function fields();

    
    
    // Magic methods

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
            }
            else {
                $string .= ", ($key): $property";
            }
        }

        return $string;
    }

    /**
     * Проверяет свойства на определенность и пустоту
     * 
     * Возвращает FALSE, если хотя бы одно из свойств не определено или пустой, иначе TRUE.
     * Лучше использовать как часть метода validate(), который определяется отдельно
     * в зависимости от соответствующих условий отбора свойств.
     */
    public function validateBasic()
    {
        $vals = get_object_vars($this);

        foreach ($vals as $val) {
            if (! isset($val) && empty($val)) {
                return false;
            }
        }

        return true;
    }

    public abstract function validate();

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
        $object = Db::select($expression)
                    ->from($this->table())
                    ->where($condition)
                    ->getObject();

        // значение key
        // $this->{$this->key()} = $object->{$this->key()}; // TODO понять синтаксис
        $this->keyValue = $object->{$this->key()};

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
        if (! $this->validate()) {
            return;
        }
        
        $vals = get_object_vars($this);

        // окружение значений пользователя одинарными кавычками
        array_walk($vals, function(&$value) { $value = "'" . "$value" . "'"; });

        Db::insert($this->table(), implode(", ", $this->fields()), implode(", ", $vals))
          ->getStatement();
    }

    public function edit()
    {
        if (! $this->validate()) {
            return;
        }
        
        $vals = get_object_vars($this);

        // окружение значений пользователя одинарными кавычками
        array_walk($vals, function(&$value) { $value = "'" . "$value" . "'"; });

        $data = "";
        $isFirst = true;
        foreach ($this->fields() as $field) {
            if ($isFirst) {
                $data .= "$field = $vals[$field]";
                $isFirst = false;
            }
            else {
                $data .= ", $field = $vals[$field]";
            }
        }

        Db::update($this->table(), $data)
          ->where("id = $this->keyValue")
          ->getStatement();
    }
}