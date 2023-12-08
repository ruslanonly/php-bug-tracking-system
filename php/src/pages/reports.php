<?php
    include(dirname(__DIR__).'/shared/model/reports.php');

    $SIDEBAR_ITEMS = array(
        "reports.php" => "Отчеты",
    );

    include(dirname(__DIR__).'/shared/lib/db/connect_database.php');
    include(dirname(__DIR__).'/shared/model/reports.php');
?>

<?php
    $sql = "SELECT id, name, description, product_id, status, priority, problem FROM report";
    $result = $_DB->query($sql);
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
        <div class="sidebar tile tile--sm">
            <form action="reports.php" method="GET" class="filter-form">
                <select class="select" name="product" id="product_select" placeholder="Любой продукт">
                    <option value="">Любой продукт</option>
                    <?php 
                        foreach($REPORT_STATUS as $num => $name) {
                            echo "
                                <option value=$num>$name</option>
                            ";
                        }
                    ?>
                </select>
                <select class="select" name="status" id="status_select" placeholder="Любой статус">
                    <option value="">Любой статус</option>
                    <?php 
                        foreach($REPORT_STATUS as $num => $name) {
                            echo "
                                <option value=$num>$name</option>
                            ";
                        }
                    ?>
                </select>
                <select class="select" name="problem" id="problem_select" placeholder="Любой тип проблемы">
                    <option value="">Любой тип проблемы</option>
                    <?php
                        foreach($REPORT_PROBLEM as $num => $name) {
                            echo "
                                <option value=$num>$name</option>
                            ";
                        }
                    ?>
                </select>
                <select class="select" name="priority" id="priority_select" placeholder="Любой приоритет">
                    <option value="">Любой приоритет</option>
                    <?php 
                        foreach($REPORT_PRIORITY as $num => $name) {
                            echo "
                                <option value=$num>$name</option>
                            ";
                        }
                    ?>
                </select>
                <input type="submit" class="button" value="Показать">
            </form>
        </div>
    </div>
    <div class="layout__col layout__col--stretched">
        <div class="tile">
            <h2 class="page__title">Список отчетов</h2>
            <div class="reports__sub-title-wrapper">
                <h3 class="page__sub-title">
                    <?php
                        $reportsAmount = mysqli_num_rows($result);
                        echo "Найдено $reportsAmount отчетов";
                    ?>
                </h3>

                <?php
                    $prevGET = $_GET;
                    if (isset($prevGET['sort_by_time'])) {
                        unset($prevGET['sort_by_time']);
                    } else {
                        $prevGET['sort_by_time'] = '1';
                    }

                    $query = http_build_query($prevGET);

                    $sortURL = "$_SERVER[PHP_SELF]?$query";
                ?>
                <div class="reports__sort">
                    <span>отсортировать</span>
                    <?php $sort = isset($_GET['sort_by_time']); ?>
                    
                    <a
                    href="<?php echo $sortURL; ?>"
                    class="reports__sort-label <?php echo $sort == '1' ? "active" : "" ?>">
                        по времени
                    </a>
                </div>
            </div>
            
            <div class="reports">
                <?php
                    foreach($result as $report) {
                        $status = $REPORT_STATUS[$report['status']];
                        echo "
                            <a class='report' href='/report.php?id=$report[id]'>
                                <div class='report__title'>$report[name]</div>
                                <div class='report__bottom'>
                                    <span class='report__createdAt'>Сегодня в 0:13</span>
                                    <span class='report__status'>$status</span>
                                </div>
                            </a>
                        ";
                    }
                ?>
            </div>
        </div>
    </div>
</div>