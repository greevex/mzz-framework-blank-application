{add file="js/jquery.js"}
{title append="Процессы"}

<div id="jipTitle">Список процессов</div>
<hr />
{form method="get" url="{url route="process" action="listProcess"}"}
    {form->submit name="submit" value="Отсортировать"}<br />
    <ul style="list-style:none">
        <li><a href="{literal}javascript:$('.filter select').each(function(){this.value = 'NO_FILTER_USE';}); $('.filter').css('background-color','transparent').css('font-weight','normal').css('color','black');{/literal}">Сбросить фильтры</a></li>
        <li>{form->checkbox name="needFilter"} Показать все фильтры</li>
        {if $needFilter}
            {foreach from=$filter item="f"}
                {assign var="defval" value="NO_FILTER_USE"}
                {assign var="val" value=$defval}
                {foreach from=$getfilters item="gfv" key="gfk"}
                    {if $gfk == $f.code}
                        {assign var="val" value=$gfv}
                    {/if}
                {/foreach}
                <li class="filter"{if $val!=$defval} style="font-weight:bold;background-color:green;color:white;"{/if}>{$f.name}: {form->select name="filter[{$f.code}]" options=$f.values value=$val}</li>
            {/foreach}
        {/if}
    </ul>
    <br />
    {form->submit name="submit" value="Отсортировать"}
</form>
<br />
<hr />
{if $pager}
    {$pager->toString()}
{/if}<hr />
<strong>Найдено: {$count_all}</strong>
<hr />
<table style="width:100%">
    <tr>
        <th style="border-bottom:1px solid black;">ID</th>
        <th style="border-bottom:1px solid black;">PID</th>
        <th style="border-bottom:1px solid black;">Модуль</th>
        <th style="border-bottom:1px solid black;">Действие</th>
        <th style="border-bottom:1px solid black;">Название</th>
        <th style="border-bottom:1px solid black;">Пользователь</th>
        <th style="border-bottom:1px solid black;">Статус</th>
        <th style="border-bottom:1px solid black;">Процент</th>
    </tr>

    {foreach from=$all item="process"}
    <tr>
            <td>
                <a href="{url route="process" action="viewProcess" id=$process->getId()}">{$process->getId()|h}</a>
            </td>
            <td>
                <a href="{url route="process" action="viewProcess" id=$process->getId()}">{$process->getPid()|h}</a>
            </td>
            <td>
                {$process->getModule()}
            </td>
            <td>
                {$process->getAction()|h}
            </td>
            <td>
                <a href="{url route="process" action="viewProcess" id=$process->getId()}">{$process->getName()|h}</a>
            </td>
            <td>
                {$process->getUser()->getName()|h}
            </td>
            <td>
                {$process->getStatus()|h}
            </td>
            <td>
                {$process->getPercent()|h}
            </td>

    </tr>
    {/foreach}
</table>