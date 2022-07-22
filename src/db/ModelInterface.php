<?php

namespace Nilixin\Edu\db;

interface ModelInterface
{

    public function table():string;
    public function fields():array;
    public function validate();
}