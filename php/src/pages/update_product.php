<?php
    include(dirname(__DIR__).'/shared/model/reports.php');

    $SIDEBAR_ITEMS = array(
        "reports.php" => "Отчеты"
    );

    include(dirname(__DIR__).'/shared/lib/db/connect_database.php');
    include(dirname(__DIR__).'/shared/model/reports.php');
?>

<?php
    $PRODUCT_ID = $_GET['id'];
    $baseQuery = "
        SELECT
            name,
            description
        FROM product WHERE id=$PRODUCT_ID
    ";
    $PRODUCT = $_DB->query($baseQuery)->fetch_assoc();
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
            <h2 class="page__title">Изменение продукта</h2>
            <div class="add_report">
                <form action='/features/actions/update_product.php' method='POST' class="form">
                    <input type="hidden" name="id" value="<?php echo $PRODUCT_ID;?>">
                    <div class="form-item">
                        <label for='name'>Название продукта</label>
                        <input class="input" type='text' name='name' value='<?php echo $PRODUCT["name"] ?>'>
                    </div>
                    <div class="form-item">
                        <label for='description'>Описание</label>
                        <input class="input" type='text' name='description' value='<?php echo $PRODUCT["description"] ?>'>
                    </div>
                    <input type="submit" class="button" value="Изменить">
                </form>
            </div>
        </div>
    </div>
</div>