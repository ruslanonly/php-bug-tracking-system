<?php
    include("./shared/lib/mysql.php");
    $manager = new DatabaseManager($hostname, $username, $password, $databaseName);
    $connection = $manager->getMySQLConnection();

    $meta_info = array(
        "title" => "Отчеты"
    );

    include "./shared/ui/layout.php";
?>