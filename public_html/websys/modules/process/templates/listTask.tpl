<p><a href="{url route="default2" module="process" action="addTask"}" class="mzz-jip-link">Добавить основную задачу</a></p>
<p><a href="{url route="default2" module="process" action="addUpdateTask"}" class="mzz-jip-link">Добавить задачу проливки</a></p>
<p><a href="{url route="default2" module="process" action="addReindexTask"}" class="mzz-jip-link">Добавить задачу переиндексации</a></p>
{form action={url} method="post"}
<table border="1">
    <tr>
        <th>id</th>
        <th>Имя</th>
        <th>Команда</th>
        <th>Параметры</th>
        <th>Метод</th>
        <th>Порядок</th>
        <th>Подзадача</th>
        <th>Действия</th>
    </tr>

    {foreach from=$all item="processTask"}
    <tr>
            <th>
                {$processTask->getId()}
            </th>
            <th colspan="6">
                {$processTask->getName()}
            </th>
            <th>
                <a href="{url route="deleter" module_name="process" class="processTask" original_action="deleteTask" field="id" value=$processTask->getId()}" class="mzz-jip-link">Удалить</a>
            </th>
    </tr>
        {$childTasks=$processTask->getChildTasks()}
        {$count=$childTasks|@count-1}
        {foreach from=$childTasks item="childTask"}
            <tr>
                <td>
                {$childTask->getId()}
            </td>
                <td>
                {$childTask->getName()}
            </td>
                    <td style="word-wrap: break-words;">
                {$childTask->getCommand()}
            </td>
                    <td>
                {$childTask->getParameters()}
            </td>
                    <td>
                {$childTask->getMethod()}
            </td>
                    <td>
                        {form->select value=$childTask->getOrder() name="task[`$childTask->getId()`][order]" options=0|range:$count}
            </td>
                    <td>

                {form->select options=$available_parents keyMethod="getId" valueMethod="getName" name="task[`$childTask->getId()`][parent_id]" value=$childTask->getParentId()}
            </td>

            <td>
                <a href="{url route="deleter" module_name="process" class="processTask" original_action="deleteTask" field="id" value=$childTask->getId()}" class="mzz-jip-link">Удалить</a>
            </td>
            </tr>
        {/foreach}


    {/foreach}
</table>


{form->submit name="submit" value="Сохранить"}
</form>

{if $pager->getPagesTotal() > 1}
    {$pager->toString()}
{/if}