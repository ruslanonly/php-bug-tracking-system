<?php
    include(dirname(__DIR__).'../../shared/lib/db/connect_database.php');

    $_GET["status"] = isset($_GET["status"]) ? $_GET["status"] :"";
    $_GET["problem"] = isset($_GET["problem"]) ? $_GET["problem"] :"";
    $_GET["priority"] = isset($_GET["priority"]) ? $_GET["priority"] :"";

    $where = "WHERE";
    $hasWhere = false;
    foreach($_GET as $key => $value) {
        if ($value != "" || $value != null) {
            $hasWhere = true;
            $where .= " ".$key ."=". $value ." AND ";
        }
    }
    $where = substr($where,0,-4);
    $baseQuery = "SELECT id, name, product_id, status, priority, problem, created_at FROM report $where";
    $sortByTime = isset($_GET['sort_by_time']) ? $_GET['sort_by_time'] : 'DESC';
    $sqlQuery = $baseQuery." ORDER BY created_at $sortByTime";
    $REPORTS = $_DB->query($sqlQuery);

    header("Content-Type: application/json; charset=UTF-8");
    $rows = mysqli_fetch_all($REPORTS, MYSQLI_ASSOC);

    echo json_encode($rows);
?>