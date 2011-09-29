{add file="blog/blog.css"}

{title append="История обновлений"}
{title append=$post->getTitle()}

<div class="post-outer">
    <div class="post">
        <h3 class="post-title">
            {$post->getTitle()}{if $post->canRun('edit')}{$post->getJip()}{/if}
        </h3>
        <div class="post-body">
            <div>{$post->getContent()|escape:html_utf}</div>
            {if $post->getLookup() == 1}
                <div>{load module=$post->getModule() action="lookup" id=$post->getDate()}</div>
            {/if}
        </div>
        <div class="post-footer">
        Автор: {$post->getAuthor()->getLogin()} | Дата публикации: {$post->getDate()|date_format:"%d.%m.%Y %H:%M"}
        </div>
    </div>
</div>