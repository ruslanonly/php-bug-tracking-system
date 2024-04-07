<?php
    include(dirname(__DIR__).'../../shared/lib/db/connect_database.php');

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $product_id = $_POST['id'];
        $baseQuery = "DELETE FROM report WHERE product_id = $product_id";
        $deleteResult = $_DB->query($baseQuery);

        $baseQuery = "DELETE FROM product WHERE id = $product_id";
        $deleteResult = $_DB->query($baseQuery);
    }

    // header("Content-Type: application/json; charset=UTF-8");
    echo "done";
?>