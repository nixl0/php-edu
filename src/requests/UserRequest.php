<?php

namespace Nilixin\Edu\requests;

class UserRequest
{
    public static function post($dto)
    {
        if (! empty($_POST)) {
            foreach ($dto->fields()['necessary'] as $field) {
                $dto->$field = $_POST[$field];
            }
        }

        return $dto;
    }

    public static function get($dto)
    {
        foreach ($dto->fields()['all'] as $field) {
            if (key_exists($field, $_GET)) {
                $dto->$field = $_POST[$field];
            }
        }

        return $dto;
    }
}
