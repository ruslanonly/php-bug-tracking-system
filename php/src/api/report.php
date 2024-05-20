<?php
    include(dirname(__DIR__).'/app/shared/lib/db/connect_database.php');

    $report_id = $_GET['id'];

    $baseQuery = "
        SELECT
            r.id,
            r.name,
            playback_steps,
            actual_result,
            expected_result,
            status,
            priority,
            problem,
            r.created_at,
            p.name as product_name,
            p.id as product_id
        FROM report as r INNER JOIN product as p ON p.id = product_id WHERE r.id=$report_id
    ";

    $REPORT = $_DB->query($baseQuery);

    header("Content-Type: application/json; charset=UTF-8");
    echo json_encode($REPORT->fetch_assoc());
?>