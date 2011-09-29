Запущено заданий: {$result|@count}
<br/>
{foreach from=$result key="id" item="task"}
    {$id}: {$task} <br />
{/foreach}