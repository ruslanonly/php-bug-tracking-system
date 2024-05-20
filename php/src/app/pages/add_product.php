<?php
    $SIDEBAR_ITEMS = array(
        "reports.php" => "Отчеты"
    );

    include(dirname(__DIR__).'/shared/lib/db/connect_database.php');
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
            <h2 class="page__title">Добавление продукта</h2>
            <form id="add-product__form" class="form">
                <div class="form-item">
                    <label for='name'>Название продукта *</label>
                    <input class="input" type='text' name='name' required>
                </div>
                <div class="form-item">
                    <label for='description'>Описание</label>
                    <input class="input" type='text' name='description'>
                </div>
                <button id="submit-button" class="button">Добавить</button>
            </form>
        </div>
    </div>
</div>

<script>
    const addProduct = (data) => {
        $.ajax({
            url: `/api/add_product.php`,
            method: 'POST',
            data,
            success: (response) => {
                window.location.href = '/products.php'
            },
            error: (error) => {
                const messages = $.parseJSON(error.responseText).messages
                messages.forEach((message) => {
                    toast(message, 'error')
                })
            }
        })
    }

    $('#submit-button').on('click', (e) => {
        e.preventDefault()

        const required = {
            name: 'Название продукта',
        }

        const requiredNames = Object.keys(required)

        let hasEmptyRequired = false;

        const formValues = {}
        $.each($('#add-product__form').serializeArray(), function(i, field) {
            formValues[field.name] = field.value

            if (requiredNames.includes(field.name) && !field.value) {
                hasEmptyRequired = true
                toast(`Поле \"${required[field.name]}\" не должно быть пустым`, 'error')
            }
        })

        if (hasEmptyRequired) {
            return
        }

        addProduct(formValues)
    })
</script>