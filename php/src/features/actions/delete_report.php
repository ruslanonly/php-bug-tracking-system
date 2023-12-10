<?php
    include(dirname(__DIR__).'../../shared/lib/db/connect_database.php');

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $id = $_POST['id'];

        $baseQuery = "DELETE FROM report WHERE id = $id";
        $deleteResult = $_DB->query($baseQuery);
        header("Location: $_SERVER[HTTP_ORIGIN]/reports.php");
    }
?>