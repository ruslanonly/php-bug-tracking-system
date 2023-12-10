<?php
    include(dirname(__DIR__).'../../shared/lib/db/connect_database.php');

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $product_id = $_POST['product_id'];
        $priority = $_POST['priority'];
        $problem = $_POST['problem'];
        $playback_steps = $_POST['playback_steps'];
        $actual_result = $_POST['actual_result'];
        $expected_result = $_POST['expected_result'];

        $baseQuery = "
            UPDATE report SET 
            name='$name',
            product_id=$product_id,
            priority=$priority,
            problem=$problem,
            playback_steps='$playback_steps',
            actual_result='$actual_result',
            expected_result='$expected_result'
            WHERE id=$id
        ";
        $updateResult = $_DB->query($baseQuery);

        $emptyStringCheckValues = array(
            "Название отчета" => $name,
            "Шаги воспроизведения" => $playback_steps,
            "Фактический результат" => $actual_result,
            "Ожидаемый результат" => $expected_result,
        );
        foreach( $emptyStringCheckValues as $key => $value ) {
            if ($value) {
                unset($emptyStringCheckValues[$key]);
            }
        }
        if (!$_DB->error && count($emptyStringCheckValues) == 0) {
            header("Location: $_SERVER[HTTP_ORIGIN]/reports.php");
        } else {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/shared/ui/layout.css">
    <title>Добавление отчета</title>
</head>
<body>
    <div class="layout_cols">
        <div class="layout__col">
        <main class="main">
            <div class="main__wrapper container">
                
                <div class='alert tile'>
                    <span class='alert__title'>
                        Возникла ошибка
                    </span>
                    <div class='alert__tesises'>
                    <?php
                        if ($_DB->error) {
                            echo "
                                <div class='alert__tesis>
                                    Не удалось изменить отчет. Возможны проблемы с неправильно указанными данными.
                                </div>
                            ";
                        }
                    ?>
                    <?php
                        foreach( $emptyStringCheckValues as $key => $value ) {
                            echo "
                                <div class='alert__tesis'>
                                    Поле $key не может быть пустым
                                </div>
                            ";
                        }
                    ?>
                    </div>
                    <div class='alert__buttons'>
                        <?php
                            echo "
                                <a href='$_SERVER[HTTP_ORIGIN]/reports.php' class='button'>Перейти к списку отчетов</a>
                                <a href='$_SERVER[HTTP_ORIGIN]/update_report.php?id=$id' class='button'>Вернуться к добавлению</a>
                            ";
                        ?>
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>
</html>

<?php } } ?>