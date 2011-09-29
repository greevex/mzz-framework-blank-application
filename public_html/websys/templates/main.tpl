{* main="header.tpl" placeholder="content" *}
{add file="jip.css"}
{add file="icons.sys.css"}
{add file="icons.flags.css"}
{add file="mctheme/jquery-ui.custom.css"}
{add file="cssf-base.css"}
{add file="iepngfix_tilebg.js"}
{add file="css_browser_selector.js"}
{add file="jip/jipCore.js"}
{add file="jip/jipMenu.js"}
{add file="jquery-ui.custom.min.js"}
{add file="jquery.scrollTo-1.4.2-min.js"}
{add file="jquery.ui.accordion.min.js"}
{add file="app.js"}
{add file="html2canvas/build/jquery.plugin.ultracenter.html2canvas.js"}
{add file="html2canvas/build/html2canvas.js"}
{add file="debug.js"}
{add file="notification/notification.css"}


<script type="text/javascript">/*
$(window).ready(function() {
  $('body').html2canvas();
});*/
</script>

{if $toolkit->getUser()->isLoggedIn()}
    {load module="notification" action="list" title="Системные объявления" tplPrefix="side_" _block="left" onlyActual='true'}
{/if}
{load module="user" action="login" title="Профиль" tplPrefix="side_" _block="left"}


<!-- Start pageBody -->
    <div id="main">
    <div id="content">
{$content}
        {foreach $fblock->get("col2bottom") as $block}
            <div class="divblock">{$block}</div>
        {/foreach}
        <div>
            {load module="user" action="online" _block="bottom"}
            {foreach $fblock->get("bottom") as $block}
                <div class="divblock">{$block}</div>
            {/foreach}
        </div>
    </div>
    </div>
<!-- End pageBody -->

<!-- Start cleaner -->
    <div class="divblock">&nbsp;<br /><br /><br /></div>
<!-- End cleaner -->
{load module="privateMessage" action="view"}

<!-- Start header -->
    <!-- Start left block -->
    <div id="left">
        <div class="left">
            {foreach $fblock->get("left") as $key => $block}
                {include file="blocks/left.block.tpl" block=$block}
            {/foreach}
        </div>
        <div id="accordion" class="left">
            {foreach $fblock->get("accordion") as $key => $block}
                {include file="blocks/left.block.tpl" block=$block}
            {/foreach}
        </div>
    </div>
    <!-- End left block -->
    <div id="header">
        <div id="menu">
            {load module="menu" action="view" name="dropdown" tplPrefix="header_"}
            {load module="user" action="login" tplPrefix="topLogin_"}
        </div>
        <div id="pageTitle">
            <h2>{title separator=" > "}</h2>
        </div>
    </div>
<!-- End header -->

<!-- Start footer -->
    {include file="footer.tpl"}
<!-- End footer -->