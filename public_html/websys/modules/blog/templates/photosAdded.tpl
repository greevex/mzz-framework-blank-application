<h4>В альбомах обновления!</h4>
<table>
        {foreach from=$photos item="photo"}
        {assign var="genreId" value=$photo->getGenre()}
        <tr style="border:1px solid black;">
            <td width="15%">
                <a title="Перейти к изображению" href="{url route="gallery" action="one" id=$photo->getId()}"><img src="{$photo->getPhoto()->getExtra()->getThumbnail(120, 80)}" alt="{$photo->getTitle()|h}" title="{$photo->getTitle()|h}" /></a>
            </td>                    
            <td width="35%">
                <a title="Перейти к изображению" href="{url route="gallery" action="one" id=$photo->getId()}">{$photo->getTitle()|h}</a><br />
            </td>
            <td width="25%">
                {$photo->getDescription()|h}</a>
            </td>
            <td width="25%">
                {if $photo->getWidth() > 0 && $photo->getHeight() > 0}{$photo->getWidth()}х{$photo->getHeight()}{/if}
                <a title="Жанр" href="{url route="gallery" action="showGenres" id=$genreId}">{$genres.$genreId}</a>
            </td>
        </tr>
        {/foreach}
</table>