<table border="1">
    <tr>
        <td>id</td>
        <td>login</td>
        <td>name</td>
        <td>В группах</td>
        <td>Доступ к</td>
    </tr>

    {foreach from=$all item="user"}
    <tr>
                    <td>
                {$user->getId()}
            </td>
                    <td>
                {$user->getLogin()}
            </td>
                    <td>
                {$user->getName()}
            </td>

    <td>
    {foreach from=$user->getGroups() item="group"}
        {$group->getName()}<br />
        {/foreach}
     </td>
     <td>
         {foreach from=$access_to[$user->getId()] key="module_name" item=module}
            {foreach item="domain" key="name" from=$access_to[$user->getId()][$module_name]}

            {if count($domain)}
                <strong>{$module_name}/{$name}</strong><br />
                {foreach key="action_name" item=action from=$domain}
                    {$name} - {if isset($action['title'])}{$action['title']} - {/if} {$action_name} <br />
                {/foreach}
            {/if}
            {/foreach}
         {/foreach}
        </td>
            </tr>
    {/foreach}
</table>

{if $pager->getPagesTotal() > 1}
    {$pager->toString()}
{/if}