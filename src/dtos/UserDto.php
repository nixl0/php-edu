<?php

namespace Nilixin\Edu\dtos;

class UserDto
{
    public function __toString()
    {
        return $this->toArray();
    }

    public function fields()
    {
        return [
            'all' => [
                'id', 'login', 'email', 'password', 'deleted_at'
            ],
            'necessary' => [
                'login', 'email', 'password'
            ]
        ];
    }

    public function toArray()
    {
        return get_object_vars($this);
    }
}