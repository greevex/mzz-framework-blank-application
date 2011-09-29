<div class="jipTitle">
    {if $isEdit}Редактирование{else}Добавление{/if} задачи
</div>

{form action=$form_action method="post" jip=true  class="mzz-jip-form"}

<div class="field{$validator->isFieldRequired('processTask[name]', ' required')} {$validator->isFieldError('processTask[name]', ' error')}">
    <div class="label">
        {form->caption name="processTask[name]" value="Имя задачи"}
    </div>
    <div class="text">
        {form->text name="processTask[name]" size="30" value=$processTask->getName()}
        {if $validator->isFieldError('processTask[name]')}<span class="caption error">{$validator->getFieldError('processTask[name]')}</span>{/if}
    </div>
</div>
<div class="field buttons">
    <div class="text">
        {form->submit name="submit" value="_ simple/save"} {form->reset jip=true name="reset" value="_ simple/cancel"}
    </div>
</div>
</form>