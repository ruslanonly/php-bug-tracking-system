<?php
    $SIDEBAR_ITEMS = array(
        "reports.php" => "Отчеты",
    );

    $PRODUCT_ID = isset($_GET['product_id']) ? $_GET['product_id'] : '';
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
            <a type="submit" class="button" style="text-align: center" href="/add_report.php">
                Создать отчет
            </a>
        </div>
        <div class="sidebar tile tile--sm">
            <form id="filter-form" class="filter-form">
                <input type="hidden" name="product_id" value="<?php echo $PRODUCT_ID;?>">
                <select class="select" name="status" placeholder="Любой статус"></select>
                <select class="select" name="problem" placeholder="Любой тип проблемы"></select>
                <select class="select" name="priority" placeholder="Любой приоритет"></select>
            </form>
        </div>
    </div>
    <div class="layout__col layout__col--stretched">
        <div class="tile">
            <h2 class="page__title">Список отчетов</h2>
            <div class="reports__sub-title-wrapper">
                <h3 id="reports__amount-label" class="page__sub-title">
                    
                </h3>

                <?php
                    $prevGET = $_GET;
                    if (isset($prevGET['sort_by_time'])) {
                        $prevGET['sort_by_time'] = $prevGET['sort_by_time'] == 'DESC' ? 'ASC' : 'DESC';
                    } else {
                        $prevGET['sort_by_time'] = 'ASC';
                    }

                    $query = http_build_query($prevGET);

                    $sortURL = "$_SERVER[PHP_SELF]?$query";
                ?>

                <div class="reports__sort">
                    <span>Сортировка по времени</span>
                    <?php
                        $sortType = isset($_GET['sort_by_time']) ? $_GET['sort_by_time']: 'DESC';
                    ?>
                    
                    <a
                    href="<?php echo $sortURL; ?>"
                    class="reports__sort-label <?php echo $sortType == 'ASC' ? "active" : "" ?>">
                        <svg fill="none" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                            <g clip-rule="evenodd" fill="currentColor" fill-rule="evenodd">
                                <path d="M16.6 18.38a.9.9 0 0 1-.9-.9V9.03l-2.06 2.07a.9.9 0 0 1-1.28-1.27L15.9 6.3a1 1 0 0 1 1.42 0l3.53 3.53a.9.9 0 0 1-1.28 1.27L17.5 9.03v8.45c0 .5-.4.9-.9.9zm-10-1.28V6.88a.9.9 0 0 1 1.8 0V17.1a.9.9 0 1 1-1.8 0z"></path>
                                <path d="M11.74 13.26a.9.9 0 0 1 0 1.28L8.2 18.07a1 1 0 0 1-1.42 0l-3.53-3.53a.9.9 0 0 1 1.28-1.28l2.96 2.97 2.96-2.97a.9.9 0 0 1 1.28 0z"></path>
                            </g>
                        </svg>
                    </a>
                </div>
            </div>
            
            <div id="report-list" class="reports"></div>
        </div>
    </div>
</div>

<script>
    const option = (value, label) => {
        return `<option value=${value}>${label}</option>`
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

    $('select[name="status"]').html(option('', 'Любой статус') + getSelectOptions(REPORT_STATUS))
    $('select[name="problem"]').html(option('', 'Любая проблема') + getSelectOptions(REPORT_PROBLEM))
    $('select[name="priority"]').html(option('', 'Любой приоритет') + getSelectOptions(REPORT_PRIORITY))

    const searchParams = useSearchParams()
    const status = searchParams.get('status')
    const problem = searchParams.get('problem')
    const priority = searchParams.get('priority')

    $(`select[name="status"] option[value=""]`).prop("selected", true)
    $(`select[name="problem"] option[value=""]`).prop("selected", true)
    $(`select[name="priority"] option[value=""]`).prop("selected", true)

    if (status) {
        $(`select[name="status"] option[value=${status}]`).prop("selected", true)
    }

    if (problem) {
        $(`select[name="problem"] option[value=${problem}]`).prop("selected", true)
    }

    if (priority) {
        $(`select[name="priority"] option[value=${priority}]`).prop("selected", true)
    }

    const report = (id, name, created_at, status) => {
        const formattedDate = formatDate(created_at)
        const mappedStatus = REPORT_STATUS[status]
        return `
            <a class='report' href='/report.php?id=${id}'>
                <div class='report__title'>${name}</div>
                <div class='report__bottom'>
                    <span class='report__createdAt'>${formattedDate}</span>
                    <span class='report__status'>${mappedStatus}</span>
                </div>
            </a>
        `
    }

    const reportsAmount = (amount) => {
        return `Найдено ${amount} отчетов`
    }

    const query = (search) => {
        $(document).ready(() => {
            let postfix = ''
            if (search) postfix += '?' + search

            $.ajax({
                url: `/features/endpoints/reports.php?${search}`,
                method: 'GET',
                complete: (response) => {
                    const reports = response.responseJSON

                    $('#report-list').html(
                        reports.map((r) => report(r.id, r.name, r.created_at, r.status))
                    )

                    $('#reports__amount-label').html(reportsAmount(reports.length));
                }
            })
        })
    }

    query(searchParams.toString())

    $('#filter-form').on('change', (e) => {
        e.preventDefault()

        $.each($('#filter-form').serializeArray(), function(i, field) {
            if (field.value) {
                searchParams.set(field.name, field.value)
            } else {
                searchParams.delete(field.name)
            }
        })
        let path = window.location.pathname
        if (searchParams.size > 0) {
            path += '?' + searchParams.toString();
        }

        history.pushState(null, '', path);

        query(searchParams.toString())
    })
</script>