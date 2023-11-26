<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? $pageTitle : "My Website"; ?></title>
</head>
<body>
    <header>
        <h1>Welcome to My Website</h1>
    </header>

    <main>
        <?php echo isset($content) ? $content : ""; ?>
    </main>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> My Website</p>
    </footer>
</body>
</html>