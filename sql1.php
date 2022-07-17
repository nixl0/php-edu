<?php

include 'sql.php';
include 'soft_del.php';

class Sql1 extends Sql {
    use SoftDelete;
}

?>