{title append="Общий лог"}
{form action={url} method="get"}
{form->hidden name="status" value=$status}
Действие: {form->text name="action_filter" value=$action_filter}
Модуль: {form->text name="module_filter" value=$module_filter}
Комментарий: {form->text name="comment_filter" value=$comment_filter}
<br />
{form->hidden name="process" value=$process}
За
{form->select options=[3600 => '1 час', 86400 => '1 день',  604800 => '1 неделя',  1209600 => '2 недели', 1814400 => '3 недели', 2678400 => 'месяц',  32140800=> '1 год'] value=$time emptyFirst="Все время" name="time"}

{form->select options=$users value=$user_id emptyFirst="Все пользователи" name="user_id"}

{form->select options=[
            0 => "Simple log",
            1 => "Notice",
            2 => "Alert, system can repair",
            3 => "Warning, system can not repair",
            4 => "Global exception, system halted"] value=$status emptyFirst="Все статусы" name="status"}
<br />
На страницу {form->select options=[25=>25, 50 => 50, 100=>100, 250 => 250, 500=>500] value=$per_page name="per_page"}
<br />
{form->submit name="submit" value="Показать"}
</form>

{if $pager->getPagesTotal() > 1}
    {$pager->toString()}
{/if}
<table border="1">
    <tr>
        <th>id</th>
        <th>Пользователь</th>
        <th>Время</th>
        <th>Модуль</th>
        <th>Действие</th>
        <th>Комментарий</th>
        <th>Статус</th>
    </tr>

    {foreach from=$all item="log"}
    <tr>
                    <td>
                {$log->getId()}
            </td>
                    <td>
                        {if $log->getUser()}
                        <a href="" title="{$log->getUser()->getLogin()|h}">{$log->getUser()->getName()}</a>
                        {/if}
            </td>
                    <td>
                {$log->getTime()|date_format:"d.m.y H:i:s"}
            </td>
                    <td>
                {$log->getModule()}
            </td>
                    <td>
                {$log->getAction()}
            </td>
                    <td>
                {$log->getComment()}
            </td>
                    <td>
                {$log->getStatus()}
            </td>
            </tr>
    {/foreach}
</table>

{if $pager->getPagesTotal() > 1}
    {$pager->toString()}
{/if}