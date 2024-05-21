<?php
    include(dirname(__DIR__).'/app/main.php');
    include(dirname(__DIR__).'/app/shared/lib/error.php');

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        header("Content-Type: application/json;");

        $id = $_POST['id'];
        $name = $_POST['name'];
        $description = $_POST['description'];

        $errors = array();

        if ($description == '') {
            $description = null;
        }

        if ($name == '') {
            $name = null;
            array_push($errors, "Название продукта не должно быть пустым");
        }

        if (count($errors) > 0) {
            http_response_code(400);
            echo json_encode(error($errors));
            exit;
        }

        $baseQuery = "
            UPDATE product SET 
            name='$name',
            description='$description'
            WHERE id=$id
        ";

        $statement = $_DB->mysqli->prepare($baseQuery);

        if (!$statement) {
            http_response_code(500);
            echo json_encode(['error' => 'Internal server error.']);
            exit;
        }

        try {
            $statement->execute();
            if ($_DB->mysqli->error) {
                throw new Exception($_DB->mysqli->error);
            }

            http_response_code(201);
            echo json_encode(success('Продукт успешно изменен'));
        } catch(Exception $e) {
            http_response_code(400);
            echo json_encode(error([$e->getMessage()]));
        }
    }
?>