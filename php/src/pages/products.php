<div class="layout__cols">
    <div class="layout__col">
        <div class="sidebar tile tile--sm">
            <a type="submit" class="button" style="text-align: center" href="/add_product.php">
                Создать продукт
            </a>
        </div>
    </div>
    <div class="layout__col layout__col--stretched">
        <div class="tile">
            <h2 class="page__title">Список продуктов</h2>
            <div class="reports__sub-title-wrapper">
                <h3 id="products-amount-label" class="page__sub-title"></h3>
            </div>
            
            <div id="product-list" class="products"></div>
        </div>
    </div>
</div>

<script>
    const product = (id, name, description) => `
        <div class='product' data-product-id='${id}'>
            <div class='product__wrapper'>
                <span class='product__name'>${name}</span>
                <span class='product__description'>${description}</span>
                <div class='product__buttons'>
                    <a href='/reports.php?product_id=${id}'>Список отчетов</a>
                    <a href='/update_product.php?id=${id}'>Редактировать</a>
                    <button class="product__delete-button">Удалить</button>
                </div>
            </div>
        </div>
    `

    const productsAmount = (amount) => `
        Найдено ${amount} продуктов
    `

    const query = () => {
        $(document).ready(() => {
            $.ajax({
                url: '/features/endpoints/products.php',
                method: 'GET',
                complete: (response) => {
                    const products = response.responseJSON

                    $('#product-list').html(
                        products.map((p) => product(p.id, p.name, p.description))
                    )

                    $('#products-amount-label').html(productsAmount(products.length));
                }
            })
        })
    }

    query()
    
    const delete_product = (id) => {
        $.ajax({
            url: `/features/endpoints/delete_product.php`,
            method: 'POST',
            data: {
                id
            },
            complete: (response) => {
                query()
            }
        })
    }

    $('#product-list').on('click', '.product .product__delete-button', function() {
        const productId = $(this).closest('.product').data('product-id')
        delete_product(productId)
    })
</script>