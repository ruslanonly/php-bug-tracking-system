<?php
    include(dirname(__DIR__).'../../shared/lib/db/connect_database.php');

    $product_id = $_GET['id'];

    $baseQuery = "SELECT id, name, description, moderated FROM product WHERE id = $product_id";
    $PRODUCTS = $_DB->query($baseQuery);

    header("Content-Type: application/json; charset=UTF-8");

    $rows = mysqli_fetch_all($PRODUCTS, MYSQLI_ASSOC);
    echo json_encode($rows);
?>