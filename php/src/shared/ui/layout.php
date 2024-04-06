<?php
    $PHP_SELF = $_SERVER["PHP_SELF"];

    $_TABS = array(
        "reports" => "Отчеты",
        "products" => "Продукты"
    );
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="/shared/ui/layout.css">
        <link rel="stylesheet" href="/pages/styles<?php echo str_replace('.php', '', $PHP_SELF); ?>.css">
        <title><?php echo isset($meta_info) ? $meta_info["title"] : "Layout Title"; ?></title>
        <script src="/shared/assets/js/jquery-3.7.1.min.js"></script>
    </head>
    <body>
        <header class="header">
            <div class="header__wrapper container">
                <div class="header__left">
                    <a class="header__logo-title" href="/home.php">
                        <div class="header__logo"></div>
                        <h1 class="header__title">Bug Tracking System</h1>
                    </a>
                    <div class="header__tabs">
                        <?php
                            foreach($_TABS as $page => $name) {
                                $activeClass = ("/".$page.".php" == $PHP_SELF) ? "active" : "";
                                echo "
                                    <a class=\"header__tab $activeClass\" href=\"/$page.php\">$name</a>
                                ";
                            }
                        ?>
                    </div>
                </div>
                
            </div>
        </header>
        

        <main class="main">
            <div class="main__wrapper container">
                <?php
                    $path = dirname(__DIR__)."../../pages".$PHP_SELF;
                    include $path;
                ?>
            </div>
        </main>
    </body>
</html>