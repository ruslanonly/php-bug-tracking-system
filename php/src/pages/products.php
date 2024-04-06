<?php
    include(dirname(__DIR__).'/shared/model/reports.php');
?>

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
        <div class='product'>
            <div class='product__wrapper'>
                <div class='product__stick'></div>
                <div class='product__content'>
                    <span class='product__name'>${name}</span>
                    <span class='product__description'>${description}</span>
                    <div class='product__buttons'>
                        <a href='/reports.php?product_id=${id}'>Список отчетов</a>
                        <a href='/update_product.php?id=${id}'>Редактировать</a>
                        <form action='/features/actions/delete_product.php' method='POST' class='filter-form'>
                            <input type='hidden' name='id' value='${id}'>
                            <input type='submit' class='button danger' href='/delete_product.php?product_id=${id}' value='Удалить'>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    `

    const productsAmount = (amount) => `
        Найдено ${amount} продуктов
    `

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
</script>