<strong>Online</strong><br />
<br />
Гостей: <strong>{if $guests > 0}{$guests}{else}0{/if}</strong><br />
Пользователей: <strong>{if $registered > 0}{$registered}{else}0{/if}</strong><br />
<br />
{if !empty($users)}
	{assign var="i" value=0}
	{foreach from=$users item="user"}
		{if $user->getUser()->getId()>1}
			<u>{$user->getUser()->getName()}</u>
            {if $toolkit->getUser()->isRoot()} смотрит <a href="{$user->getUrl()}" >{$user->getUrl()|truncate:70}</a>{/if}{assign var="i" value=$i+1}{if $i < $registered},<br />{else}.{/if}
		{/if}
	{/foreach}
{/if}