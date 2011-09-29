<table border="1">
    <tr>
        <td>id</td>
        <td>name</td>
        <td>enabled</td>
    </tr>

    {foreach from=$all item="watch"}
    <tr>
            <td>
                {$watch->getId()}
            </td>
            <td>
                {$watch->getName()}{if $watch->canRun('activate')}{$watch->getJip()}{/if}
            </td>
                    <td>
                {$watch->getEnabled()}
            </td>
            </tr>
    {/foreach}
</table>

{if $pager->getPagesTotal() > 1}
    {$pager->toString()}
{/if}