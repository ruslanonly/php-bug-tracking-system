<?php
    include(dirname(__DIR__).'/shared/model/reports.php');

    $SIDEBAR_ITEMS = array(
        "reports.php" => "Отчеты"
    );

    include(dirname(__DIR__).'/shared/lib/db/connect_database.php');
    include(dirname(__DIR__).'/shared/model/reports.php');
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
            <h2 class="page__title">Добавление отчета</h2>
            <div class="add_report">
                <form action='/features/actions/add_report.php' method='POST' class="form">
                    <div class="form-item">
                        <label for='name'>Название</label>
                        <input class="input" type='text' name='name'>
                    </div>
                    <div class="form-item">
                        <label for='product_id'>Продукт</label>
                        <select class="select" name="product_id" placeholder="Любой продукт">
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
                        <label for='priority'>Приоритет</label>
                            <select class="select" name="priority" placeholder="Любой приоритет">
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
                        <select class="select" name="problem" placeholder="Любой тип проблемы">
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
                        <textarea class="input" name='playback_steps'></textarea>
                    </div>
                    <div class="form-item">
                        <label for='name'>Фактический результат</label>
                        <textarea class="input" name='actual_result'></textarea>
                    </div>
                    <div class="form-item">
                        <label for='name'>Ожидаемый результат</label>
                        <textarea class="input" name='expected_result'></textarea>
                    </div>
                    <input type="submit" class="button" value="Добавить">
                </form>
            </div>
        </div>
    </div>
</div>