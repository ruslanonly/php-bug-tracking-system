<?php
    include(dirname(__DIR__).'../../shared/lib/db/connect_database.php');

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = $_POST['name'];
        $description = $_POST['description'];

        $baseQuery = "INSERT INTO product (name, description) VALUES ('$name', '$description')";

        if ($description == '') {
            $description = null;
        }

        if ($name == '') {
            $name = null;
        }

        $emptyStringCheckValues = array(
            "Название продукта" => $name,
        );
        foreach( $emptyStringCheckValues as $key => $value ) {
            if ($value) {
                unset($emptyStringCheckValues[$key]);
            }
        }
        if (!$_DB->error && count($emptyStringCheckValues) == 0) {
            $insertResult = $_DB->query($baseQuery);
        } else {
            echo "Возникла ошибка";
        }
    }
?>