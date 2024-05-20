<?php
    include(dirname(__DIR__).'/app/shared/lib/db/connect_database.php');

    $product_id = $_GET['id'];

    $baseQuery = "SELECT id, name, description, moderated FROM product WHERE id = $product_id";
    $PRODUCT = $_DB->query($baseQuery);

    header("Content-Type: application/json; charset=UTF-8");
    echo json_encode($PRODUCT->fetch_assoc());
?>