{if isset($__media['js'])}
{strip}
    {assign var="external" value=""}
    {foreach from=$__media.js item="jsitem" key="file" name="jsFiles"}
    {if $jsitem.join}
        {assign var="currentFile" value=$file}
        {assign var="external" value="$external$currentFile,"}
    {else}
        {include file=$jsitem.tpl filename=$file}
    {/if}
    {/foreach}
    {if $external}
        {if !$version}
            {assign var="version" value="stable"}
        {/if}
        <script type="text/javascript" src="{$SITE_PATH}/external.php?type=js&amp;files={$external|substr:0:-1}&amp;version={$version}"></script>
    {/if}
{/strip}
{/if}