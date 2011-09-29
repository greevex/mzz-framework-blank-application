<div class="sideBlockContent">
    <p id="openapi_user" class="sideBlockTitle">{$user->getLogin()|h}</p>
    <ul style="list-style:none;padding:0;">
     <li><a href="{url route="default2" module="user" action="exit"}/?url={{url appendGet=true}|urlencode}">{_ logout}</a></li>
    </ul>
</div>