{if !empty($title) && !empty($content)}
<div id="notification">
<span id="notification_id">{$id}</span>
<div id="notification_title"><span id="notification_close">Закрыть [X]</span>{$title}</div>
<div id="notification_content">{$content}<hr /><span id="notification_author"><strong>Автор: </strong>({$author->getLogin()}) / {$author->getName()}</span></div>
</div>
{/if}