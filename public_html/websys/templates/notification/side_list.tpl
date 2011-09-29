<table border="1">
    {assign var="i_c" value=$all|@count}
    {assign var="i" value=0}
    {foreach from=$all item="notification"}
        {assign var="i" value=$i+1}
    <tr>
        <th>{$notification->getTitle()}</th>
    </tr>
    <tr>
        <th>{$notification->getContent()|strip_tags}</th>
    </tr>
    <tr>
        <th style="font-weight:normal;font-size: 80%;">{$notification->getUser()->getName()}
        Дата: {$notification->getDateStart()}</th>
    </tr>
    {if $i<$i_c}
    <tr>
        <th>___________</th>
    </tr>
    {/if}
    {foreachelse}
    <tr>
        <th>Нет записей</th>
    </tr>
    {/foreach}
</table>