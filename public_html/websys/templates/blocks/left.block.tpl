{if is_array($block)}
    {assign var="title" value=$block.title}
    {assign var="block" value=$block.view}
    <h3><a href="#{$title}">{$title}</a></h3>
{/if}
<div class="sideBlock">
{$block}
</div>