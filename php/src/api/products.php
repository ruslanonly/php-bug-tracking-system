<?php
    include(dirname(__DIR__).'/app/shared/lib/db/connect_database.php');

    $baseQuery = "SELECT id, name, description, moderated FROM product";
    $PRODUCTS = $_DB->query($baseQuery);

    header("Content-Type: application/json; charset=UTF-8");

    $rows = mysqli_fetch_all($PRODUCTS, MYSQLI_ASSOC);
    echo json_encode($rows);
?>