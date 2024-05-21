<style>
    .header-wrapper {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .header-wrapper * {
        width: min-content;
        text-wrap: nowrap;
        margin-bottom: 16px;
    }
</style>
<div class="layout__cols">
    <div class="layout__col layout__col--stretched">
        <div class="tile">
            <div class="header-wrapper">
                <h2 class="page__title">Логин</h2>
                <a class="button button-link" href="/register.php">Регистрация</a>
            </div>
            <form id="login__form" class="form">
                <div class="form-item">
                    <label for='login'>Логин *</label>
                    <input class="input" type='text' name='login' required>
                </div>
                <div class="form-item">
                    <label for='password'>Пароль *</label>
                    <input class="input" type='password' name='password' required>
                </div>
                <button id="submit-button" class="button">Войти</button>
            </form>
        </div>
    </div>
</div>
<script>
    const login = (data) => {
        console.log(data)
        $.ajax({
            url: `/api/auth/login.php`,
            method: 'POST',
            data,
            success: (response) => {
                window.location.href = '/reports.php'
            },
            error: (response) => {
                toast('Не удалось войти в систему', 'error')
            }
        })
    }
    $('#submit-button').on('click', (e) => {
        e.preventDefault()

        const required = {
            name: 'Псевдоним пользователя',
            email: 'Почта',
            password: 'Пароль'
        }

        const requiredNames = Object.keys(required)

        let hasEmptyRequired = false;

        const formValues = {}
        $.each($('#login__form').serializeArray(), function(i, field) {
            formValues[field.name] = field.value
            const formItem = $(`label[for='${field.name}']`).parent()
            const fieldName = formItem.find('label').text().replace('*', '').trim()
            const input = formItem.find('[name]')

            if (input.attr('required') && !field.value) {
                hasEmptyRequired = true
                toast(`Поле \"${fieldName}\" не должно быть пустым`, 'error')
            }
        })

        if (hasEmptyRequired) {
            return
        }

        login(formValues)
    })
</script>