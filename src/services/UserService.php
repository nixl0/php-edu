<?php

namespace Nilixin\Edu\services;

use Nilixin\Edu\models\UserModel;
use Nilixin\Edu\models\PictureModel;
use Nilixin\Edu\models\StatusModel;

class UserService
{
    public static function add($bigDto)
    {
        try {
            // users
            $addableUserDto = array();
            
            $addableUserDto['username'] = $bigDto->username;
            $addableUserDto['password'] = $bigDto->password;
            $addableUserDto['email'] = $bigDto->email;

            // pictures
            $pictureModel = new PictureModel;
            $pictureExists = $pictureModel->exists("path = '$bigDto->picture'"); // проверка существует ли такой path в pictures
            if (! $pictureExists) $pictureModel->add((object) ["path" => $bigDto->picture]); // добавляется, если не существует
            $pictureDto = $pictureModel->selectOne("path = '$bigDto->picture'"); // возвращается объект с таким path
            
            $addableUserDto['picture'] = $pictureDto->id;

            // statuses
            $statuseModel = new StatusModel;
            $statusExists = $statuseModel->exists("title = '$bigDto->status'"); // проверка существует ли такой title в statuses
            if ($statusExists) {
                $statusDto = $statuseModel->selectOne("title = '$bigDto->status'"); // возвращается объект с таким title

                $addableUserDto['status'] = $statusDto->id;
            }

            $addableUserDto = (object) $addableUserDto;
            
            $userModel = new UserModel;
            
            $message = $userModel->add($addableUserDto);

            return $message;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
