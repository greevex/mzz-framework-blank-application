{title append="Письма отправлены"}
<h3>Письма отправлены следующим неподтвержденным пользователям:</h3>
{foreach from=$users item=$u}
	{$u->getLogin()} ({$u->getEmail()})<br />
{/foreach}