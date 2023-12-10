<?php
    include(dirname(__DIR__).'/shared/model/reports.php');

    $SIDEBAR_ITEMS = array(
        "reports.php" => "Отчеты",
    );

    include(dirname(__DIR__).'/shared/lib/db/connect_database.php');
    include(dirname(__DIR__).'/shared/model/reports.php');
?>

<?php
    $REPORT_ID = $_GET['id'];
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
            created_at,
            p.name as product_name 
        FROM report as r INNER JOIN product as p ON p.id = product_id WHERE r.id=$REPORT_ID
    ";
    $REPORT = $_DB->query($baseQuery)->fetch_assoc();
?>

<div class="layout__cols">
    <div class="layout__col">
        <div class="sidebar tile tile--sm">
            <?php
                foreach($SIDEBAR_ITEMS as $page => $name) {
                    $activeClass = ("/".$page.".php" == $PHP_SELF) ? "active" : "";
                    echo "
                        <a class=\"sidebar__item $activeClass\" href=\"/$page\">$name</a>
                    ";
                }
            ?>
        </div>
        <?php
            if ($REPORT != null)
            echo "
                <div class='sidebar tile tile--sm'>
                    <div class='sidebar__buttons'>
                        <a type='submit' class='button' style='text-align: center' href='/update_report.php?id=$REPORT[id]'>
                            Изменить отчет
                        </a>
                        <form action='/features/actions/delete_report.php' method='POST'>
                            <input type='hidden' name='id' value='$REPORT[id]'>
                            <input type='submit' class='button danger' value='Удалить'>
                        </form>
                    </div>
                </div>
            ";
        ?>
        
    </div>
    <div class="layout__col layout__col--stretched">
        <div class="tile">
            <?php
                if ($REPORT == null) {
                    echo "<h2 class='page__title'>Отчет не найден</h2>";
                } else {
            ?>
            <h2 class="page__title">Отчет</h2>
            <div class="report">
                <div class="report__main">
                    <h2 class="report__title"><?php echo $REPORT['name'];?></h2>
                    <?php
                        $reportItems = array(
                            'playback_steps' => 'Шаги воспроизведения',
                            'actual_result' => 'Фактический результат',
                            'expected_result' => 'Ожидаемый результат'
                        );
                        foreach($reportItems as $reportItemName => $reportItemTitle) {
                            $content = $REPORT[$reportItemName] ? $REPORT[$reportItemName] : 'Информация не указана';
                            echo "
                                <div class='report__item'>
                                    <span class='report__item-title'>$reportItemTitle</span>
                                    <div class='report__item-content'>$content</div>
                                </div>
                            ";
                        }
                    ?>
                </div>
                <div class="report__info">
                    <?php
                        $descriptionItems = array(
                            'Продукт' => $REPORT['product_name'],
                            'Статус' => $REPORT_STATUS[$REPORT['status']],
                            'Тип проблемы' => $REPORT_PROBLEM[$REPORT['problem']],
                            'Приоритет' => $REPORT_PRIORITY[$REPORT['priority']]
                        );
                        foreach($descriptionItems as $descriptionItemName => $descriptionItemValue) {
                            echo "
                                <div class='report__info-row'>
                                    <div class='report__info-row-label'>$descriptionItemName</div>
                                    <div class='report__info-row-value'>$descriptionItemValue</div>
                                </div>
                            ";
                        }
                    ?>
                </div>
            </div>
            <?php
                }
            ?>
        </div>
    </div>
</div>