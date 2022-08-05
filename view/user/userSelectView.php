{{ title }}Hello{{ /title }}
{{ body }}
    <h1>Юзер</h1>
    
    <form class="user-select-form" action="/user/show" method="POST">
        <label class="user-select-form__title-label">Напишите id пользователя:</label>
        <div class="user-select-form_column">
            <input class="user-select-form__input-ID" type="text" name="id">
            <input class="user-select-form__submit-button" type="submit" value="Отправить">
        </div>
    </form>
{{ /body }}