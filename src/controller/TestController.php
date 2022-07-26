<?php

namespace Nilixin\Edu\controller;

class TestController
{
    public function index()
    {
        echo "<h1>Test</h1>";
    }

    public function submit()
    {
        return '<form action="/test/submit" method="POST">
        <label>text</label>
        <input type="text" name="text">
        </form>';
    }

    public function store()
    {
        $text = $_POST['text'];

        var_dump($text);
    }
}