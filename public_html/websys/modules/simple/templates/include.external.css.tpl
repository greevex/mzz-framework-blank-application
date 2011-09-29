{if isset($__media['css'])}
{strip}
    {assign var="external" value=""}
    {foreach from=$__media.css item="cssitem" key="file" name="cssFiles"}
    {if $cssitem.join}
        {assign var="currentFile" value=$file}
        {assign var="external" value="$external$currentFile,"}
    {else}
        {include file=$cssitem.tpl filename=$file}
    {/if}
    {/foreach}
    {if $external}
        {if !$version}
            {assign var="version" value="stable"}
        {/if}
        <link rel="stylesheet" type="text/css" href="{$SITE_PATH}/external.php?type=css&amp;files={$external|substr:0:-1}&amp;version={$version}" />
    {/if}
{/strip}
{/if}