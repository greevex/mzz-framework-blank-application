{title append="Системные сообщения"}
<a href="{url route="default2" action="add"}">Добавить системное сообщение</a>
<table border="1">
    <tr>
        <th>id</th>
        <th>Пользователь</th>
        <th>Заголовок</th>
        <th>Контент</th>
        <th>Дата начала</th>
        <th>Дата конца</th>
        <th>Действия</th>
    </tr>

    {foreach from=$all item="notification"}
    <tr>
                    <td>
                {$notification->getId()}
            </td>
                    <td>
                {$notification->getUser()->getLogin()} ({$notification->getUser()->getName()})
            </td>
                    <td>
                {$notification->getTitle()}
            </td>
                    <td>
                {$notification->getContent()}
            </td>
                    <td>
                {$notification->getDateStart()}
            </td>
                    <td>
                {$notification->getDateEnd()}
            </td>
            <td>
              <a href="{url route="withId" action="edit" id=$notification->getId() module_="notification"}">Редактировать</a> |
                <a href="{url route="deleter" original_action="delete" class="notification" field="id" value=$notification->getId() module_name="notification"}" class="mzz-jip-link">Удалить</a>
            </td>
            </tr>

    {/foreach}
</table>

{if $pager->getPagesTotal() > 1}
    {$pager->toString()}
{/if}