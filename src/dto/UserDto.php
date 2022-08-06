<?php

namespace Nilixin\Edu\dto;

class UserDto
{
    public $login;
    public $email;
    public $password;

    public function __construct()
    {

    }

    /**
     * @param $data
     * @return UserDto
     */
    public static function load($data)
    {
        $dto = new self();
        if (is_array($data)){
            $dto->login = $data['login'];
            $dto->email = $data['email'];
            $dto->password = $data['password'];
        }
        else{
            $dto->login = $data->login;
            $dto->email = $data->email;
            $dto->password = $data->password;
        }

        return $dto;
    }

}