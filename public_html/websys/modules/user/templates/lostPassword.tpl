{if $e}
	{if $notfound}
		<h2>{_ wrongEmail}</h2>
        <a href="{url route="default2" module="user" action="lostPassword"}">Попробовать снова</a>
	{else}
		{if $sended}
			<h2>{_ email_confirm_sent} {$user->getEmail()}</h2>
		{else}
			<h2>Error</h2>
		{/if}
	{/if}
{else}
	{if $user==null && !$notfount && !$sended && !$good}
		{_ sendPassMePlz}<br />
		{form action={url route="default2" module="user" action="lostPassword"} method="get"}
		{form->caption name="email" value="E-mail:"} {form->text name="email"}<br />
		{form->submit name="submit" value="Ok"}
		</form>
	{/if}
	{if $notfound==false}
		{if $good}
		<h2>{_ passChanged}</h2>
		{else}
		ERROR ON SEND NEW PASSWORD
		{/if}
	{/if}
{/if}