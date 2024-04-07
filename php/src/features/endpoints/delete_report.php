<?php
    include(dirname(__DIR__).'../../shared/lib/db/connect_database.php');

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $id = $_POST['id'];
        print($id);
        $baseQuery = "DELETE FROM report WHERE id = $id";
        $deleteResult = $_DB->query($baseQuery);
    }

    header("Content-Type: application/json; charset=UTF-8");
    echo json_encode($deleteResult);
?>