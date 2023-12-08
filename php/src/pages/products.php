<?php
    $SIDEBAR_ITEMS = array(
        "products.php" => "Каталог продуктов",
        "products.php?moderated" => "Модерируемые"
    );
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
                <button type="submit" class="button">Добавить продукт</button>
            </form>
        </div>
    </div>
    <div class="layout__col layout__col--stretched">
        <div class="tile">
            <h2 class="page__title">Список продуктов</h2>
        </div>
    </div>
</div>