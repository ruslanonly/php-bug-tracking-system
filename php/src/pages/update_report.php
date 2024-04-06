<?php
    include(dirname(__DIR__).'/shared/model/reports.php');

    $SIDEBAR_ITEMS = array(
        "reports.php" => "Отчеты"
    );

    include(dirname(__DIR__).'/shared/lib/db/connect_database.php');
    include(dirname(__DIR__).'/shared/model/reports.php');
?>

<?php
    $REPORT_ID = $_GET['id'];
    $baseQuery = "
        SELECT
            id,
            name,
            product_id,
            playback_steps,
            actual_result,
            expected_result,
            status,
            priority,
            problem,
            created_at 
        FROM report WHERE id=$REPORT_ID
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
    </div>
    <div class="layout__col layout__col--stretched">
        <div class="tile">
            <h2 class="page__title">Изменение отчета</h2>
            <div class="add_report">
                <form action='/features/actions/update_report.php' method='POST' class="form">
                    <input type="hidden" name="id" value="<?php echo $REPORT_ID;?>">
                    <div class="form-item">
                        <label for='name'>Название</label>
                        <input class="input" type='text' name='name' value='<?php echo $REPORT["name"] ?>'>
                    </div>
                    <div class="form-item">
                        <label for='product_id'>Продукт</label>
                        <select class="select" name="product_id" placeholder="Любой продукт" value='<?php echo $REPORT["product_id"] ?>'>
                            <?php
                                $baseQuery = "SELECT id, name FROM product";
                                $productsResult = $_DB->query($baseQuery);
                                foreach($productsResult as $product) {
                                    echo "
                                        <option value=$product[id]>$product[name]</option>
                                    ";
                                }
                            ?>
                        </select>
                    </div>
                    <div class="form-item">
                        <label for='status'>Статус</label>
                        <select class="select" name="status" placeholder="Любой статус" value='<?php echo $REPORT["status"] ?>'>
                            <?php 
                                foreach($REPORT_STATUS as $num => $name) {
                                    echo "
                                        <option value=$num>$name</option>
                                    ";
                                }
                            ?>
                        </select>
                    </div>
                    <div class="form-item">
                        <label for='priority'>Приоритет</label>
                            <select class="select" name="priority" placeholder="Любой приоритет" value='<?php echo $REPORT["priority"] ?>'>
                            <?php 
                                foreach($REPORT_PRIORITY as $num => $name) {
                                    echo "
                                        <option value=$num>$name</option>
                                    ";
                                }
                            ?>
                        </select>
                    </div>
                    <div class="form-item">
                        <label for='problem'>Проблема</label>
                        <select class="select" name="problem" placeholder="Любой тип проблемы" value='<?php echo $REPORT["problem"] ?>'>
                            <?php
                                foreach($REPORT_PROBLEM as $num => $name) {
                                    echo "
                                        <option value=$num>$name</option>
                                    ";
                                }
                            ?>
                        </select>
                    </div>
                    <div class="form-item">
                        <label for='name'>Шаги воспроизведения</label>
                        <textarea class="input" name='playback_steps'><?php echo $REPORT["playback_steps"] ?></textarea>
                    </div>
                    <div class="form-item">
                        <label for='name'>Фактический результат</label>
                        <textarea class="input" name='actual_result'><?php echo $REPORT["actual_result"] ?></textarea>
                    </div>
                    <div class="form-item">
                        <label for='name'>Ожидаемый результат</label>
                        <textarea class="input" name='expected_result' ><?php echo $REPORT["expected_result"] ?></textarea>
                    </div>
                    <input type="submit" class="button" value="Сохранить изменения">
                </form>
            </div>
        </div>
    </div>
</div>