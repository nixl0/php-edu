<?php

namespace Nilixin\Edu\models;

use Exception;
use Nilixin\Edu\dtos\UserDto;
use Nilixin\Edu\services\UserService;
use Nilixin\Edu\validations\UserValidation;
use Nilixin\Edu\db\Db;

class UserModel
{
    public function dbo()
    {
        return Db::init();
    }

    public function table()
    {
        return 'users';
    }

    public function validator()
    {
        return UserValidation::class;
    }

    public function validationRules()
    {
        return [
            'login' => [
                'rule' => 'plain',
                'min' => 3,
                'max' => 64
            ],
            'email' => [
                'rule' => 'email'
            ],
            'password' => [
                'min' => 6,
                'max' => 128
            ]
        ];
    }

    public function pop($dto, $entry)
    {
        if (! empty($dto) || ! empty($entry)) {
            foreach ($dto->fields()['all'] as $field) {
                if (key_exists($field, $entry)) {
                    $dto->$field = $entry[$field];
                }
            }
        }

        return $dto;
    }

    public function edit($dto, $values)
    {
        if (! empty($dto) || ! empty($values)) {
            foreach ($values as $key => $value) {
                if (property_exists($dto, $key)) {
                    $dto->$key = $value;
                }
                else {
                    throw new Exception('Property not found');
                }
            }
        }

        return $dto;
    }
}