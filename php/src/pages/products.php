<?php
    include(dirname(__DIR__).'/shared/model/reports.php');

    $SIDEBAR_ITEMS = array(
        "products.php" => "Список продуктов",
        "products.php?moderated" => "Модерируемые продукты"
    );

    include(dirname(__DIR__).'/shared/lib/db/connect_database.php');
?>

<?php
    $moderated = isset($_GET['moderated']);
    $baseQuery = "SELECT id, name, description, moderated FROM product";
    if ($moderated) {
            $baseQuery .= " WHERE moderated=1";
    }
    $PRODUCTS = $_DB->query($baseQuery);
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
            <a type="submit" class="button" style="text-align: center" href="/add_report.php">
                Создать продукт
            </a>
        </div>
    </div>
    <div class="layout__col layout__col--stretched">
        <div class="tile">
            <h2 class="page__title">Список отчетов</h2>
            <div class="reports__sub-title-wrapper">
                <h3 class="page__sub-title">
                    <?php
                        $productsAmount = mysqli_num_rows($PRODUCTS);
                        echo "Найдено $productsAmount продуктов";
                    ?>
                </h3>
            </div>
            
            <div class="reports">
                <?php
                    include(dirname(__DIR__).'/shared/lib/date.php');
                    setlocale(LC_TIME, 'ru_RU.utf8');
                    foreach($PRODUCTS as $product) {
                        echo "
                            <div class='product'>
                                <div class='product__left'>
                                    <div class='product__stick'></div>
                                    <div class='product__content'></div>
                                </div>
                                <div class='product__button'>
                                    <a href='/reports.php?product_id=$product[id]' class='button'>Список отчетов</a>
                                </div>
                            </div>
                        ";
                    }
                ?>
            </div>
        </div>
    </div>
</div>