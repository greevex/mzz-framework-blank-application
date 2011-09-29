<h2>{_ email_creation}</h2><br /><br />
{if $result}
	<h3>{$email}</h3><br />
	<p>{_ email_registered}</p>
{else}
	<p>{_ email_error}</p>
{/if}