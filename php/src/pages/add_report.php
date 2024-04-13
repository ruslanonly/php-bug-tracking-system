<?php
    $SIDEBAR_ITEMS = array(
        "reports.php" => "Отчеты"
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
    </div>
    <div class="layout__col layout__col--stretched">
        <div class="tile">
            <h2 class="page__title">Добавление отчета</h2>
            <div class="add_report">
                <form id="report-form" class="form">
                    <div class="form-item">
                        <label for='name'>Название *</label>
                        <input class="input" type='text' name='name' required>
                    </div>
                    <div class="form-item">
                        <label for='product_id'>Продукт *</label>
                        <select class="select" name="product_id" placeholder="Любой продукт" required></select>
                    </div>
                    <div class="form-item">
                        <label for='priority'>Приоритет</label>
                            <select class="select" name="priority" placeholder="Любой приоритет"></select>
                    </div>
                    <div class="form-item">
                        <label for='problem'>Проблема *</label>
                        <select class="select" name="problem" placeholder="Любой тип проблемы" required></select>
                    </div>
                    <div class="form-item">
                        <label for='name'>Шаги воспроизведения *</label>
                        <textarea class="input" name='playback_steps' required></textarea>
                    </div>
                    <div class="form-item">
                        <label for='name'>Фактический результат *</label>
                        <textarea class="input" name='actual_result' required></textarea>
                    </div>
                    <div class="form-item">
                        <label for='name'>Ожидаемый результат *</label>
                        <textarea class="input" name='expected_result' required></textarea>
                    </div>
                    <input type="submit" class="button" value="Добавить">
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    const option = (value, label, selected) => {
        if (selected) {
            return `<option value="${value}" selected>${label}</option>`
        } else {
            return `<option value="${value}">${label}</option>`
        }
    }

    const getSelectOptions = (options) => {
        let html = ''

        for(let i = 0; i < options.length; i++) {
            const optionName = options[i]
            html += option(i, optionName)
        }

        return html
    }

    const emptyOption = option('empty', )

    $('select[name="problem"]').html(option('', 'Проблема не выбрана') + getSelectOptions(REPORT_PROBLEM))
    $('select[name="priority"]').html(option('', 'Приоритет не выбран') + getSelectOptions(REPORT_PRIORITY))

    $(document).ready(() => {
        $.ajax({
            url: '/features/endpoints/products.php',
            method: 'GET',
            success: (products) => {
                const html = option('', 'Продукт не выбран') + products.map((p) => option(p.id, p.name))
                $('select[name="product_id"]').html(html)
            },
            error: () => {
                toast('Не удалось получить список продуктов', 'error')
            }
        })
    })

    const addReport = (data) => {
        $.ajax({
            url: `/features/endpoints/add_report.php`,
            method: 'POST',
            data,
            success: (response) => {
                window.location.href = '/reports.php'
            },
            error: (error) => {
                const messages = $.parseJSON(error.responseText).messages
                messages.forEach((message) => {
                    toast(message, 'error')
                })
            }
        })
    }

    $('#report-form').on('submit', (e) => {
        e.preventDefault()

        const formValues = {}
        $.each($('#report-form').serializeArray(), function(i, field) {
            formValues[field.name] = field.value
        })

        addReport(formValues)
    })
</script>