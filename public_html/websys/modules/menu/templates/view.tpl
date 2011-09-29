{foreach from=$items key="id" item="item"}
    <span class="{if $item->isActive()}menu_active{/if}"><span><a title="{$item->getDescription()|h}" href="{$item->getUrl()}">{$item->getTitle()}</a></span></span>
{/foreach}