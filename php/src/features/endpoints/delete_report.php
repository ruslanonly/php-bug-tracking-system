<?php
    include(dirname(__DIR__).'../../shared/lib/db/connect_database.php');
    include(dirname(__DIR__).'../../shared/lib/error.php');

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $report_id = $_POST['id'];

        $baseQuery = "DELETE FROM report WHERE id = $report_id";
        $deleteResult = $_DB->query($baseQuery);

        header("Content-Type: application/json; charset=UTF-8");
        echo json_encode(success("Отчет с id = $report_id успешно удален"));
    }
?>