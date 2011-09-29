{if $isEdit}
  {title append="Редактирование новой задачи"}
{else}
  {title append="Создание новой задачи"}
{/if}

<div class="jipTitle">
    {if $isEdit}Редактирование{else}Создание{/if} новой задачи
</div>

{form action=$form_action method="post" jip=true  class="mzz-jip-form"}


<div class="field{$validator->isFieldRequired('schedulerTask[start_date]', ' required')} {$validator->isFieldError('schedulerTask[start_date]', ' error')}">
    <div class="label">
        {form->caption name="schedulerTask[start_date]" value="День начала"}
    </div>
    <div class="text">
        {form->text id="edit_task_start_date" name="schedulerTask[start_date]" size="30" value=$schedulerTask->getStartDate()}
        {if $validator->isFieldError('schedulerTask[start_date]')}<span class="caption error">{$validator->getFieldError('schedulerTask[start_date]')}</span>{/if}
    </div>
</div>
<div class="field{$validator->isFieldRequired('schedulerTask[start_time]', ' required')} {$validator->isFieldError('schedulerTask[start_time]', ' error')}">
    <div class="label">
        {form->caption name="schedulerTask[start_time]" value="Время начала"}
    </div>
    <div class="text">
        {form->text id="edit_task_start_time" name="schedulerTask[start_time]" size="30" value=$schedulerTask->getStartTime()|substr:0:5}
        {if $validator->isFieldError('schedulerTask[start_time]')}<span class="caption error">{$validator->getFieldError('schedulerTask[start_time]')}</span>{/if}
    </div>
</div>
<div class="field{$validator->isFieldRequired('schedulerTask[command]', ' required')} {$validator->isFieldError('schedulerTask[command]', ' error')}">
    <div class="label">
        {form->caption name="schedulerTask[command]" value="Команда"}


    </div>
    <div class="text">

        {if $isEdit && $schedulerTask->getType() == 3}
        {form->select options=$tasks keyMethod="getId" value=$schedulerTask->getCommand()->getId() id="command_task" valueMethod="getName" name="schedulerTask[command]"}
        {else}
        {form->text name="schedulerTask[command]" size="30" value=$schedulerTask->getCommand()}
        {/if}
        {if $validator->isFieldError('schedulerTask[command]')}<span class="caption error">{$validator->getFieldError('schedulerTask[command]')}</span>{/if}
    </div>
</div>
<div class="field{$validator->isFieldRequired('schedulerTask[parameters]', ' required')} {$validator->isFieldError('schedulerTask[parameters]', ' error')}">
    <div class="label">
        {form->caption name="schedulerTask[parameters]" value="Параметры"}
    </div>
    <div class="text">
        {form->textarea name="schedulerTask[parameters]"  value=$schedulerTask->getParameters()}
        {if $validator->isFieldError('schedulerTask[parameters]')}<span class="caption error">{$validator->getFieldError('schedulerTask[parameters]')}</span>{/if}
    </div>
</div>
<div class="field{$validator->isFieldRequired('schedulerTask[times_to_run]', ' required')} {$validator->isFieldError('schedulerTask[times_to_run]', ' error')}">
    <div class="label">
        {form->caption name="schedulerTask[times_to_run]" value="Кол-во запусков"}
    </div>
    <div class="text">
        {form->text name="schedulerTask[times_to_run]" size="10" value=$schedulerTask->getTimesToRun()}<p>(0 - неограниченно)</p>
        {if $validator->isFieldError('schedulerTask[times_to_run]')}<span class="caption error">{$validator->getFieldError('schedulerTask[times_to_run]')}</span>{/if}
    </div>
</div>
<div class="field{$validator->isFieldRequired('schedulerTask[interval]', ' required')} {$validator->isFieldError('schedulerTask[interval]', ' error')}">
    <div class="label">
        {form->caption name="schedulerTask[interval]" value="Интервал"}
    </div>
    <div class="text">
        {form->text name="schedulerTask[interval]" size="10" value=$schedulerTask->getInterval()}
        {if $validator->isFieldError('schedulerTask[interval]')}<span class="caption error">{$validator->getFieldError('schedulerTask[interval]')}</span>{/if}
    </div>
</div>
<div class="field{$validator->isFieldRequired('schedulerTask[method]', ' required')} {$validator->isFieldError('schedulerTask[method]', ' error')}">
    <div class="label">
        {form->caption name="schedulerTask[method]" value="Метод"}
    </div>
    <div class="text">
        {form->select options=[1 => 'POST', 2 => 'GET'] name="schedulerTask[method]" value=$schedulerTask->getMethod()}
        {if $validator->isFieldError('schedulerTask[method]')}<span class="caption error">{$validator->getFieldError('schedulerTask[method]')}</span>{/if}
    </div>
</div>
<div class="field buttons">
    <div class="text">
        {form->submit name="submit" value="_ simple/save"} {form->reset jip=true name="reset" value="_ simple/cancel"}
    </div>
</div>
</form>
<script>
        $('#edit_task_start_date').datepicker({ dateFormat: 'dd.mm.yy' });
        setTimepicker('edit_task_start_time');
</script>
