<span id="topLogin" class="f-right topLoginText">
{$user->getLogin()|h} <span style="font-weight: lighter">({$user->getName()|h})</span> <a href="{url route='default2' module='user' action='exit' _url={url appendGet=true encode=true} _csrf}">{_ logout}</a>
</span>