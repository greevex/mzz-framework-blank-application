<ul>
{foreach from=$items item="item" key="id" name="itemIteration"}
    {strip}{if !$smarty.foreach.itemIteration.first}
        {if $item->getTreeLevel() < $lastLevel}
            {math equation="x - y" x=$lastLevel y=$item->getTreeLevel() assign="levelDown"}
            {"</li></ul>"|@str_repeat:$levelDown}</li>
        {elseif $lastLevel == $item->getTreeLevel()}
            </li>
        {else}
            <ul>
        {/if}
    {/if}{/strip}
    <li {if $item->isActive()} class="activeNavElement"{/if} >
        <a {if $item->isJip()}class="mzz-jip-link" {/if}title="{$item->getDescription()|h}" href="{$item->getUrl()|h}">{$item->getTitle()|h}</a>
    {strip}{assign var="lastLevel" value=$item->getTreeLevel()}
    {if $smarty.foreach.itemIteration.last}
        {math equation="x - y" x=$lastLevel y=1 assign="levelDown"}
        {"</li></ul>"|@str_repeat:$levelDown}</li>
    {/if}{/strip}
{/foreach}
</ul>