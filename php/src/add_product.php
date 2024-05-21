<?php
    include_once dirname(__FILE__) . '/app/main.php';

    $authGuard->canActivate();

    include("./app/shared/lib/page.php");
    $meta_info = createMetaInformation("Добавление продукта");

    include "./app/shared/ui/layout.php";
?>