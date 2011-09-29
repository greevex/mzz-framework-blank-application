<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html>
 <head>
  <title>{systemConfig::$appName}{title separator=" > " start=" | "}</title>
	    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	    <meta name="generator" content="{$smarty.const.MZZ_NAME} v.{$smarty.const.MZZ_VERSION} / App Version: {$smarty.const.MZZ_REVISION}" />
        <meta http-equiv="imagetoolbar" content="no" />
        <link href="{$SITE_PATH}/css/style.css" media="screen" rel="stylesheet" type="text/css" />
        <!--[if lte IE 6]><link rel="stylesheet" href="css/cssf-ie6.css" type="text/css" media="screen" /><![endif]-->
        <!--[if IE 7]><link rel="stylesheet" href="css/cssf-ie7.css" type="text/css" media="screen" /><![endif]-->
        {include file='include.external.css.tpl' version="30.08.2011"}
        <script type="text/javascript">
            //<!--
            var SITE_PATH = '{$SITE_PATH}';
            var SITE_LANG = '{$toolkit->getLocale()->getName()}';
            var SITE_DOMAIN = '{$toolkit->getRequest()->getHttpHost()}';
            //-->
        </script>
        {include file='include.external.js.tpl' version="30.08.2011"}
        <script type="text/javascript">
            var notification_interval = null;
            var recieving_notification = false;
            function startLoadingNotification()
            {
                if (recieving_notification) return;
                notification_interval = setInterval(loadNotification, 10000);
            }
            function stopLoadingNotification()
            {
                if (recieving_notification) return;
                clearInterval(notification_interval);
                notification_interval = null;
            }
            function loadNotification()
            {
                recieving_notification = true;
                $('#notification_base').load('/notification/show', function (e) {
                    recieving_notification = false;
                    if ($(this).html() != '') {
                        showDebugInformation();
                        stopLoadingNotification();
                    }
                });
            }
                $(document).ready(function() {
                    (function($){
                    $.fn.disableSelection = function() {
                        return this.each(function() {
                            $(this).attr('unselectable', 'on')
                                   .css({
                                       '-moz-user-select':'none',
                                       '-webkit-user-select':'none',
                                       'user-select':'none'
                                   })
                                   .each(function() {
                                       this.onselectstart = function() { return false; };
                                   });
                        });
                    };

                })(jQuery);
                $('#notification_close').live('click', function() {
                    $('#loadingPleaseWait').show();
                    $('#debugInformation').html('');
                    $('#debugInformation').hide();
                    recieving_notification = true;
                    $('#notification_base').load('/notification/' + $('#notification_id').text() + '/close', function(e) {
                        recieving_notification = false;
                        $('#notification_base').html('');
                        $('#loadingPleaseWait').hide();
                        startLoadingNotification();
                    });
                });
                $('#runDebug').click(function() {
                    $('#footer,.sideSlide').hide();
                    $('#debugInformation,#selectedArea').show();
                    runDebug();
                });
                $('#sendDebug').click(function() {
                    $('#debug_tooltip').slideUp();
                    $('#sendDebug,#sendCancel,#footer,#error_description_brb').hide();
                    $('html').html2canvas();
                });

                var cancel_callback = function() {
                    $('#footer,.sideSlide').show();
                    $('#debug_tooltip').slideUp();
                    $('#loadingPleaseWait,#debugInformation,#selectedArea,#error_description_brb,#sendDebug,#sendCancel').hide();
                };
                $('#sendCancel').click(cancel_callback);

                $('body').keydown(function (e) {
                    if (e.keyCode === 27) {
                        cancel_callback();
                    }
                });
                startLoadingNotification();
            });
        </script>
    </head>
    <body>
        <div id="debug_tooltip" style="display: none;">
            Выделите мышкой область, в которой присутствует ошибка
        </div>
        {$content}

        <!-- DEBUG -->
        <div id="selectedArea">&nbsp;</div>
        <div id="debugInformation">&nbsp;</div>
        <div id="loadingPleaseWait">&nbsp;</div>
        <div id="runDebug">Сообщение разработчикам</div>
        <textarea id="error_description_brb"></textarea>
        <div id="sendDebug">Отправить разработчикам</div>
        <div id="sendCancel">Отмена</div>
        <!-- /DEBUG -->
        <!-- NOTIFICATION -->
        <div id="notification_base"></div>
        <!-- /NOTIFICATION -->
    </body>
</html>