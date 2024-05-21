<?php
    include(dirname(__DIR__).'/app/main.php');
    include(dirname(__DIR__).'/app/shared/lib/error.php');

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $product_id = $_POST['id'];
        $baseQuery = "DELETE FROM report WHERE product_id = $product_id";
        $deleteResult = $_DB->query($baseQuery);

        $baseQuery = "DELETE FROM product WHERE id = $product_id";
        $deleteResult = $_DB->query($baseQuery);

        header("Content-Type: application/json; charset=UTF-8");
        echo json_encode(success("Продукт с id = $product_id успешно удален"));
    }
?>