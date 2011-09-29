{add file="blog/blog.css"}
{assign var=iteration value=0}

<h2>{if $newp->canRun('delete')}{$newp->getJip()}{/if}</h2>
<div class="blog-posts">
{foreach from=$posts item="post"}
    {if $post->getSticky() == 1}
        {assign var=iteration value=$iteration+1}
        <div class="post-outer">
            <div class="post">
                <h3 class="post-title">
                    <a href="{url route="default2" module="blog" action=$post->getId()}">{$post->getTitle()}</a>{if $post->canRun('edit')}{$post->getJip()}{/if}
                </h3>
                <div class="post-body">
                    <div>{$post->getContent()|escape:html_utf}</div>
                    {if $post->getLookup() == 1}
                        <div>{load module=$post->getModule() action="lookup" id=$post->getDate()}</div>
                    {/if}
                </div>
                <div class="post-footer">
                    Автор: {$post->getAuthor()->getLogin()} |
                    Дата публикации: {$post->getDate()|date_format:"%d.%m.%Y %H:%M"} |
                </div>
            </div>
        </div>
    {/if}
{/foreach}
{foreach from=$posts item="post"}
    {if $post->getSticky() == 0}
        {assign var=iteration value=$iteration+1}
        <div class="post-outer">
	        <div class="post">
		        <h3 class="post-title">
			        <a href="{url route="default2" module="blog" action=$post->getId()}">{$post->getTitle()}</a>{if $post->canRun('edit')}{$post->getJip()}{/if}
		        </h3>
		        <div class="post-body">
		            <div>{$post->getContent()|escape:html_utf}</div>
                    {if $post->getLookup() == 1}
                        <div>{load module=$post->getModule() action="lookup" id=$post->getDate()}</div>
                    {/if}
		        </div>
		        <div class="post-footer">
		            Автор: {$post->getAuthor()->getLogin()} |
                    Дата публикации: {$post->getDate()|date_format:"%d.%m.%Y %H:%M"} |
		        </div>
	        </div>
        </div>
    {/if}
{/foreach}
</div>