<?php

include 'db.php';
include 'soft_delete.php';

class Db1 extends Db
{
    use SoftDelete;
}

?>