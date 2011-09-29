{title append="Регистрация пользователя"}
<h2>Регистрация пользователя</h2>
{form action=$form_action method="post"}
    <table>
        <tr>
            <td><strong>{form->caption name="login" value="Логин в системе:"}</strong></td>
            <td>
                {form->text name="login" size="30" maxlength="255"}
                {if $validator->isFieldError('login')}<div class="error">{$validator->getFieldError('login')}</div>{/if}
            </td>
        </tr>
        <tr>
            <td><strong>{form->caption name="name[last]" value="Фамилия:"}</strong></td>
            <td>
                {form->text name="name[last]" size="30" maxlength="255"}
                {if $validator->isFieldError('name[last]')}<div class="error">{$validator->getFieldError('name[last]')}</div>{/if}
            </td>
        </tr>
        <tr>
            <td><strong>{form->caption name="name[first]" value="Имя:"}</strong></td>
            <td>
                {form->text name="name[first]" size="30" maxlength="255"}
                {if $validator->isFieldError('name[first]')}<div class="error">{$validator->getFieldError('name[first]')}</div>{/if}
            </td>
        </tr>
        <tr>
            <td><strong>{form->caption name="name[patronymic]" value="Отчество:"}</strong></td>
            <td>
                {form->text name="name[patronymic]" size="30" maxlength="255"}
                {if $validator->isFieldError('name[patronymic]')}<div class="error">{$validator->getFieldError('name[patronymic]')}</div>{/if}
            </td>
        </tr>
        <tr>
            <td><strong>{form->caption name="email" value="E-mail:"}</strong></td>
            <td>
                {form->text name="email" size="30" maxlength="255"}
                {if $validator->isFieldError('email')}<div class="error">{$validator->getFieldError('email')}</div>{/if}
            </td>
        </tr>
        <tr>
            <td><strong>{form->caption name="password" value="Пароль:"}</strong></td>
            <td>
                {form->password name="password" size="30" maxlength="255"}
                {if $validator->isFieldError('password')}<div class="error">{$validator->getFieldError('password')}</div>{/if}
            </td>
        </tr>
        <tr>
            <td><strong>{form->caption name="repassword" value="Повтор пароля:"}</strong></td>
            <td>
                {form->password name="repassword" size="30" maxlength="255"}
                {if $validator->isFieldError('repassword')}<div class="error">{$validator->getFieldError('repassword')}</div>{/if}
            </td>
        </tr>
        <tr>
            <td colspan="2">{form->submit name="submit" value="Зарегистрировать"}</td>
        </tr>
    </table>
</form>