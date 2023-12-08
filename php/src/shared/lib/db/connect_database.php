<?php
    include(dirname(__DIR__).'/db/mysql.php');
    
    function connectBTSDatabase() {
        $MYSQL_HOSTNAME = 'db';
        $MYSQL_DATABASE = 'bts_database';
        $MYSQL_USER = 'bts_user';
        $MYSQL_PASSWORD = 'bts_password';

        $_DB = new DatabaseManager($MYSQL_HOSTNAME, $MYSQL_USER, $MYSQL_PASSWORD, $MYSQL_DATABASE);

        return $_DB;
    }

    $_DB = connectBTSDatabase();
?>