<?php

include 'db.php';
include 'soft_del.php';

class Db1 extends Db {
    use SoftDelete;
}

?>