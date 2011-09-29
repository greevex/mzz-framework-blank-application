<div class="jipTitle">
    {if $isEdit}Редактирование{else}Создание{/if} адресата оповещения
</div>

{form action=$form_action method="post" jip=true  class="mzz-jip-form"}
{if !$isEdit}
<div class="field{$validator->isFieldRequired('notificationConfig[user_id]', ' required')} {$validator->isFieldError('notificationConfig[user_id]', ' error')}">
    <div class="label">
        {form->caption name="notificationConfig[user_id]" value="Пользователь"}
    </div>
    <div class="text">
        {form->select name="notificationConfig[user_id]" options=$users keyMethod="getId" valueMethod="getName" value=$notificationConfig->getUser()}
        {if $validator->isFieldError('notificationConfig[user_id]')}<span class="caption error">{$validator->getFieldError('notificationConfig[user_id]')}</span>{/if}
    </div>
</div>
{/if}
<div class="field{$validator->isFieldRequired('notificationConfig[event]', ' required')} {$validator->isFieldError('notificationConfig[event]', ' error')}">
    <div class="label">
        {form->caption name="notificationConfig[event]" value="Событие"}
    </div>
    <div class="text">
        {form->select name="notificationConfig[event]" options=$events keyMethod="getName" valueMethod="getLabel" value=$notificationConfig->getEvent()}
        {if $validator->isFieldError('notificationConfig[event]')}<span class="caption error">{$validator->getFieldError('notificationConfig[event]')}</span>{/if}
    </div>
</div>
<div class="field buttons">
    <div class="text">
        {form->submit name="submit" value="_ simple/save"} {form->reset jip=true name="reset" value="_ simple/cancel"}
    </div>
</div>
</form>