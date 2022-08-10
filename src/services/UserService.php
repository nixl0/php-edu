<?php

namespace Nilixin\Edu\services;

use Nilixin\Edu\dtos\UserDto;
use Nilixin\Edu\models\UserModel;

class UserService
{
    const ACTIVE = 1;

    public function create(UserDto $userDto)
    {
        $user = new UserModel();

        $user->login = $userDto->login;
        $user->email = $userDto->email;
        $user->password = $this->passwordCreateHash($userDto->password);

        $user->add();

        UserModel::q()->create($userDto);

        return $user;
    }

    public function update()
    {

    }

    /**
     * @param $id
     * @return UserModel
     */
    public function getOne($id): UserModel
    {
        $user = UserModel::q()->selectOne("id = $id");


        return $user;
    }

    public function delete()
    {

    }

    /**
     * @param string $password
     * @return string
     */
    public function passwordCreateHash(string $password): string
    {
        return md5($password);
    }

    public function validatePassword($password)
    {
        // TODO и сюда подключать ту же валидацию, что и в модели?
    }

}