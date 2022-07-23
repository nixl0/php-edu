<?php

namespace Nilixin\Edu\Controller;

class UserController
{
    public function index()
    {
        echo "<h1>User</h1>";
    }

    public function select()
    {
        return '<form action="/user/show" method="POST">
        <label>Напишите id</label>
        <input type="text" name="id">
        </form>';
    }

    public function show()
    {
        $id = $_POST['id'];

        var_dump($id);
    }
}