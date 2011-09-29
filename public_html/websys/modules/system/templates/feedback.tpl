Пользователь {$user->getLogin()} ({$user->getName()}) сообщил об ошибке!
<hr />
<strong>Источник:</strong> {$location}<br />
<strong>Дата:</strong> {php}echo date("d.m.Y H:i:s");{/php}<br />
<strong>Текст:</strong> {$description|h}<br />
<hr />
<a href="{$imagefile}">Дебаг изображение</a>