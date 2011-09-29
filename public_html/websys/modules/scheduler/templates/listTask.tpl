{title append="Планировщик задач"}
{title append="Список задач"}
{add file="jquery.min.js"}
{add file="jquery-ui.custom.min.js"}
{add file="mctheme/jquery-ui.custom.css"}
{add file="timepicker/jquery-ui-timepicker-addon.js"}
{add file="jquery-ui-timepicker-addon.css"}
{form action="{url action="addTask" route="default2" module="scheduler"}" method="post" id="create_new_task"}
<table border="1">
    <tr>
        <th>Время запуска</th>
        <th>Дата запуска</th>
        <th>Интервал</th>
        <th>Запустить раз</th>
        <th>Тип команды</th>
        <th>Метод и Команда</th>
        <th>Параметры</th>
        <th>Статус</th>
        <th>Запущено раз</th>
        <th>Последний запуск</th>
        <th>Действия</th>
    </tr>

    {foreach from=$all item="schedulerTask"}
    <tr>
                    <td>
                {if $schedulerTask->getStartTime()}{$schedulerTask->getStartTime()}{else}-{/if}
            </td><td>
                {if $schedulerTask->getStartDate()}{$schedulerTask->getStartDate()}{else}-{/if}
            </td>
                    <td>
                {if $schedulerTask->getInterval()}{$schedulerTask->getInterval()}{else}-{/if}
            </td>
                    <td>
                {if $schedulerTask->getTimesToRun()}{$schedulerTask->getTimesToRun()}{else}&#8734;{/if}
            </td>
                    <td>
                {$schedulerTask->getTypeTitle()}
            </td>
                    <td><div style="width: 200px; overflow: auto;">
                            <p><b>{$schedulerTask->getMethodTitle()}</b></p>
                {if $schedulerTask->getType() == 3}
                    {$schedulerTask->getCommand()->getName()}
                {else}
                    {$schedulerTask->getCommand()}
                {/if}
                        </div>
            </td>
            <td style="width: 200px; ">
                <div style="width: 200px; overflow: auto;">
                {$schedulerTask->getParameters()}
                </div>
            </td>
            <td>
                {$schedulerTask->getStatusTitle()}
            </td>

            <td>{$schedulerTask->getExecutionCount()}</td>
            <td>{$schedulerTask->getLastExecution()|date_format:"d/m/Y H:i:s"}</td>

                    <td>
               <p>{if (int)$schedulerTask->getStatus() === 1}
               <a class="mzz-jip-link" href="{url route="schedulerTaskStatus" module="scheduler" action="changeTaskStatus" status="0" id=$schedulerTask->getId()}">Деактивировать</a>
               {else}
               <a class="mzz-jip-link" href="{url route="schedulerTaskStatus" module="scheduler" action="changeTaskStatus" status="1" id=$schedulerTask->getId()}">Активировать</a>
               {/if}</p>
               <p><a class="mzz-jip-link"  href="{url route="withId" module="scheduler" action="editTask" id=$schedulerTask->getId()}">Изменить</a> |</p>
               <p><a class="mzz-jip-link"  href="{url route="deleter" module_name="scheduler" class="schedulerTask" original_action="deleteTask" field="id" value=$schedulerTask->getId()}">Удалить</a></p>
            </td>

            </tr>
    {/foreach}
    <tr>
        <td>
            {form->text name="schedulerTask[start_time]" size=6}
        </td>
        <td>
            {form->text name="schedulerTask[start_date]" size=6}
        </td>
        <td>
            {form->text name="schedulerTask[interval]" size=3} мин.
        </td>
        <td>
            {form->text name="schedulerTask[times_to_run]" size=3}
        </td>
        <td>
            {form->select options=[1 => 'Внешняя', 2 => 'Внутр.', 3 => 'Задача'] name="schedulerTask[type]"}
        </td>
        <td>
            <p>Метод: {form->select options=[1 => 'POST', 2 => 'GET'] name="schedulerTask[method]"}</p>
            {form->text name="schedulerTask[command]"}
            {form->select options=$tasks keyMethod="getId" style="display:none" disabled=true id="command_task" valueMethod="getName" name="schedulerTask[command]"}
        </td>
        <td>
            <p class="task_param" style="border-bottom: 2px solid gray; margin: 4px 0; padding: 4px 0;">
                <label style="display: block;width: 40px;">Имя</label> {form->text name="schedulerTask[parameters][name][]"}<br/>
                <label style="display: block;width: 40px;">Значение</label> {form->text name="schedulerTask[parameters][value][]"}
            </p>
            <a href="#" class="add_task_param">Добавить новый параметр</a>
        </td>
        <td>
            {form->submit name="submit" value="Добавить"}
        </td>
    </tr>

</table>
</form>
{if $pager->getPagesTotal() > 1}
    {$pager->toString()}
{/if}
<script type="text/javascript">
    (function ($) {
        $('#formElm_schedulerTask_start_date').datepicker({ dateFormat: 'dd.mm.yy' });
        setTimepicker('formElm_schedulerTask_start_time');
    })(jQuery);

    $('.add_task_param').click(function (e) {
        e.stopPropagation();
        var new_param =   $('.task_param').first().clone(true);
        $(new_param).find('input').val('');

        //$('.add_task_param').parents('td').insertBefore(new_param);
        $(new_param).insertBefore($('.add_task_param'));
        return false;
    });

    $('#create_new_task').submit(function (e) {
        if (($("#command_task").is(':visible') && !$("#command_task").val())
            || (!$("#command_task").is(':visible') && $("#formElm_schedulerTask_command").val() == '')) {
            e.stopPropagation();
            alert('Введите текст команды!');
            $("#formElm_schedulerTask_command").focus();
            return false;
        }
    });

    $('#formElm_schedulerTask_type').change(function() {
        if ($(this).val() === '3') {
            $('#formElm_schedulerTask_command').hide();
            $('#command_task').show().removeAttr('disabled');
        } else {
            $('#formElm_schedulerTask_command').show();
            $('#command_task').hide().attr('disabled', 'true');
        }
    })
</script>