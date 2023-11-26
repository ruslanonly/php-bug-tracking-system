<?php
    include("./shared/lib/mysql.php");
    $manager = new DatabaseManager($hostname, $username, $password, $databaseName);
    $connection = $manager->getMySQLConnection();

    $meta_info = array(
        "title" => "Продукты"
    );

    include "./shared/ui/layout.php";
?>