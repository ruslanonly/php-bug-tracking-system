<?php
    include(dirname(__DIR__).'/app/shared/lib/db/connect_database.php');
    include(dirname(__DIR__).'../../shared/lib/error.php');

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = $_POST['name'];
        $product_id = (int)$_POST['product_id'];
        $priority = (int)$_POST['priority'];
        $problem = (int)$_POST['problem'];
        $playback_steps = $_POST['playback_steps'];
        $actual_result = $_POST['actual_result'];
        $expected_result = $_POST['expected_result'];

        $errors = array();
        $emptyStringCheckValues = array(
            "Название отчета" => $name,
            "Продукт" => $product_id,
            "Проблема" => $problem,
            "Шаги воспроизведения" => $playback_steps,
            "Фактический результат" => $actual_result,
            "Ожидаемый результат" => $expected_result,
        );

        if ($product_id == null || $product_id == '') {
            array_push($errors, "Поле \"Продукт\" не должно быть пустым");
        }

        foreach( $emptyStringCheckValues as $key => $value ) {
            if (!$value && $value != 0) {
                array_push($errors, "Поле \"".$key."\" $value не должно быть пустым");
            }
        }

        if (count($errors) > 0) {
            http_response_code(400);
            echo json_encode(error($errors));
            exit;
        }

        $baseQuery = "INSERT INTO report (name, product_id, priority, problem, playback_steps, actual_result, expected_result) VALUES (?, ?, ?, ?, ?, ?, ?)";
        
        $statement = $_DB->mysqli->prepare($baseQuery);



        if (!$statement) {
            http_response_code(500);
            echo json_encode(['error' => 'Internal server error.']);
            exit;
        }

        $statement->bind_param("siiisss", $name, $product_id, $priority, $problem, $playback_steps, $actual_result, $expected_result);

        try {
            $statement->execute();
            if ($_DB->mysqli->error) {
                throw new Exception($_DB->mysqli->error);
            }

            http_response_code(201);
            echo json_encode(success('Отчет успешно добавлен'));
        } catch(Exception $e) {
            http_response_code(400);
            echo json_encode(error([$e->getMessage()]));
        }
    }
?>