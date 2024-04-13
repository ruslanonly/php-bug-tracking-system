<?php
    $SIDEBAR_ITEMS = array(
        "reports.php" => "Отчеты",
    );

    $REPORT_ID = $_GET['id'];
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
        <div class='sidebar tile tile--sm'>
            <div class='sidebar__buttons'>
                <a type='submit' class='button' style='text-align: center' href='/update_report.php?id=<?php echo $REPORT_ID?>'>
                    Изменить отчет
                </a>
                <button id='delete_report' type='submit' class='button danger'>Удалить</button>
            </div>
        </div>
        
    </div>
    <div class="layout__col layout__col--stretched">
        <div class="tile">
            <h2 class="page__title">Отчет</h2>
            <div class="report">
                <div class="report__main">
                    <h2 class="report__title"></h2>
                    <div class='report__item'></div>
                </div>
                <div class="report__info"></div>
            </div>
        </div>
    </div>
</div>

<script>
    const reportTitle = (name) => {
        $('h2.report__title').html(name)
    }

    const reportMain = (report) => {
        const reportItems = {
            'playback_steps': 'Шаги воспроизведения',
            'actual_result': 'Фактический результат',
            'expected_result': 'Ожидаемый результат'
        }

        for(const itemName in reportItems) {
            const title = reportItems[itemName]

            const content = report[itemName] ? report[itemName] : 'Информация не указана';
            $('.report__main').append(`
                <div class='report__item'>
                    <span class='report__item-title'>${title}</span>
                    <div class='report__item-content'>${content}</div>
                </div>
            `)
        }
    }

    const reportInfo = (report) => {
        const reportInfoItems = {
            'Дата создания': formatDate(report['created_at']),
            'Продукт': report['product_name'],
            'Статус': REPORT_STATUS[report['status']],
            'Тип проблемы': REPORT_PROBLEM[report['problem']],
            'Приоритет': REPORT_PRIORITY[report['priority']]
        }

            
        for(const reportInfoItemName in reportInfoItems) {
            const reportInfoItemValue = reportInfoItems[reportInfoItemName]

            $('.report__info').append(`
                <div class='report__info-row'>
                    <div class='report__info-row-label'>${reportInfoItemName}</div>
                    <div class='report__info-row-value'>${reportInfoItemValue}</div>
                </div>
            `)
        }
    }

    const query = (id) => {
        $(document).ready(() => {
            $.ajax({
                url: `/features/endpoints/report.php?id=${id}`,
                method: 'GET',
                complete: (response) => {
                    const report = response.responseJSON
                    
                    if (report) {
                        reportTitle(report.name)
                        reportMain(report)
                        reportInfo(report)
                    } else {
                        $('.report').parent().html('<h2 class="page__title">Отчет не найден</h2>')
                    }
                }
            })
        })
    }

    const searchParams = useSearchParams()
    const report_id = searchParams.get('id')

    if (report_id) {
        query(report_id)
    } else {
        $('.report').html('<h2 class="page__title">Неизвестный отчет</h2>')
    }

    const delete_report = (id) => {
        $.ajax({
            url: `/features/endpoints/delete_report.php`,
            method: 'POST',
            data: {
                id
            },
            complete: (response) => {
                window.location.href = '/reports.php'
            }
        })
    }

    $('#delete_report').on('click', () => {
        delete_report(report_id)
    })
</script>