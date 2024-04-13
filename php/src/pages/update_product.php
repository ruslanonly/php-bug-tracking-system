<?php
    $SIDEBAR_ITEMS = array(
        "reports.php" => "Отчеты"
    );

    $PRODUCT_ID = $_GET['id'];
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
                <form id="update-product__form" class="form">
                    <input type="hidden" name="id" value="<?php echo $PRODUCT_ID;?>">
                    <div class="form-item">
                        <label for='name'>Название продукта *</label>
                        <input class="input" type='text' name='name' required>
                    </div>
                    <div class="form-item">
                        <label for='description'>Описание</label>
                        <input class="input" type='text' name='description'>
                    </div>
                    <button id="submit-button" class="button">Изменить</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    const searchParams = useSearchParams()
    const product_id = searchParams.get('id')

    const queryProduct = (id) => {
        $.ajax({
            url: `/features/endpoints/product.php?id=${id}`,
            method: 'GET',
            success: (response) => {
                const product = response
                $('input[name="name"]').val(product.name)
                $('input[name="description"]').val(product.description)
            },
            error: (error) => {
                const messages = $.parseJSON(error.responseText).messages
                messages.forEach((message) => {
                    toast(message, 'error')
                })
            }
        })
    }

    queryProduct(product_id)

    const updateProduct = (data) => {
        $.ajax({
            url: `/features/endpoints/update_product.php`,
            method: 'POST',
            data: {
                ...data,
                id: product_id
            },
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
        $.each($('#update-product__form').serializeArray(), function(i, field) {
            formValues[field.name] = field.value

            if (requiredNames.includes(field.name) && !field.value) {
                hasEmptyRequired = true
                toast(`Поле \"${required[field.name]}\" не должно быть пустым`, 'error')
            }
        })

        if (hasEmptyRequired) {
            return
        }

        updateProduct(formValues)
    })
</script>