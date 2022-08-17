<?php

namespace Nilixin\Edu\requests;

class UserRequest extends Request
{
    public function fields()
    {
        return ["id", "username", "password", "email", "picture", "status", "deleted_at", "updated_at"];
    }
}
