<?php
    include(dirname(__DIR__).'../../shared/lib/db/connect_database.php');

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $id = $_POST['id'];
        $baseQuery = "DELETE FROM report WHERE product_id = $id";
        $deleteResult = $_DB->query($baseQuery);

        $baseQuery = "DELETE FROM product WHERE id = $id";
        $deleteResult = $_DB->query($baseQuery);
        header("Location: $_SERVER[HTTP_ORIGIN]/products.php");
    }
?>