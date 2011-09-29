<a class="mzz-jip-link" href="{url route="default2" module="user" action="addNotificationConfig"}">Добавить пользователя</a>
<hr />
<table border="0">
    <thead>
    <tr class="first">
        <th class="first">id</th>
        <th>Пользователь</th>
        <th>Событие</th>
        <th class="last">Действия</th>
    </tr>
    </thead>
    {foreach from=$all item="notificationConfig"}
    <tr>
                    <td>
                {$notificationConfig->getId()}
            </td>
                    <td>
                {$notificationConfig->getUser()->getName()}
            </td>
                    <td>
                {$notificationConfig->getEventLabel()}
            </td>
            </td>
            <td>
                <a class="mzz-jip-link" href="{url route="withId" module="user" action="editNotificationConfig" id=$notificationConfig->getId()}">Редактировать</a>
                <a href="{url route="deleter" original_action="deleteNotificationConfig" class="notificationConfig" field="id" value=$notificationConfig->getId() module_name="user"}" class="mzz-jip-link">Удалить</a>
            </td>
            </tr>
    {/foreach}
</table>

{if $pager->getPagesTotal() > 1}
    {$pager->toString()}
{/if}