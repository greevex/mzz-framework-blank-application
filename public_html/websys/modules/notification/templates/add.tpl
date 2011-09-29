<div class="jipTitle">
    {if $isEdit}Редактирование {else}Создание{/if} системного сообщения
</div>
{add file="jquery.min.js"}
{add file="jquery-ui.custom.min.js"}
{add file="mctheme/jquery-ui.custom.css"}
{add file="timepicker/jquery-ui-timepicker-addon.js"}
{add file="jquery-ui-timepicker-addon.css"}
{add file="timepicker/localization/jquery-ui-timepicker-ru.js"}


<script type="text/javascript">
{literal}
fileLoader.loadJS(SITE_PATH + '/js/tiny_mce/jquery.tinymce.js');

(function($) {
    toggleEditor = function(id) {
        if (!(tinyMCE) || tinyMCE.getInstanceById(id) == null) {
            $('#' + id).tinymce({
                script_url: SITE_PATH + '/js/tiny_mce/tiny_mce.js',
                theme : "advanced",
                skin : 'o2k7',
                skin_variant : "",
                mode : "none",
                plugins : "inlinepopups,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras",
                language : "ru",
                theme_advanced_buttons1_add : "fontselect,fontsizeselect",
                theme_advanced_buttons2_add_before: "paste,pastetex,separator",
                theme_advanced_buttons3_add_before : "insertdate,inserttime,separator,tablecontrols,separator",
                theme_advanced_toolbar_location : "top",
                theme_advanced_toolbar_align : "left",
                theme_advanced_path_location : "bottom",
                plugin_insertdate_dateFormat : "%Y-%m-%d",
                plugin_insertdate_timeFormat : "%H:%M:%S",
                extended_valid_elements : "hr[class|width|size|noshade],font[face|size|color|style],span[class|align|style]",
                /*external_link_list_url : "example_link_list.js",
                external_image_list_url : "example_image_list.js",
                flash_external_list_url : "example_flash_list.js",
                media_external_list_url : "example_media_list.js",*/
                theme_advanced_resize_horizontal : false,
                theme_advanced_resizing : true,
                nonbreaking_force_tab : true,
                apply_source_formatting : true,
                add_unload_trigger : false,
                add_form_submit_trigger: false,
                relative_urls : false,
                remove_script_host: true,
                file_browser_callback: function (field_name, url, type, win) {
                    tinyMCE.activeEditor.windowManager.open({
                        'file' : '/fileBrowser/browse?tiny_mce=true',
                        'title' : 'mzz file browser',
                        'width' : 700,
                        'height' : 480,
                        'resizable' : "yes",
                        'inline' : "yes",
                        'close_previous' : "no",
                         'popup_css' : false
                    }, {
                        'window' : win,
                        'input' : field_name,
                        'url': url,
                        'type': type,
                        'jip': jipWindow,
                    });
                    return false;
                },
                oninit : function(){jipWindow.resize()}
            });



            jipWindow.addTinyMCEId(id);
            $('#' + id + '_editorStatus').text('Выключить WYSIWYG-редактор');
        } else {
            tinyMCE.execCommand('mceRemoveControl', false, id);
            jipWindow.deleteTinyMCEId(id);
            $('#' + id + '_editorStatus').text('Включить WYSIWYG-редактор');
            jipWindow.resize();
        }
    }
})(jQuery);
{/literal}
</script>


{form action=$form_action method="post" class="mzz-jip-form" onsubmit="if (tinyMCE) tinyMCE.triggerSave(true, true); "}
<div class="field{$validator->isFieldRequired('notification[title]', ' required')} {$validator->isFieldError('notification[title]', ' error')}">
    <div class="label">
        {form->caption name="notification[title]" value="Заголовок"}
    </div>
    <div class="text">
        {form->text name="notification[title]" size="30" value=$notification->getTitle()}
        {if $validator->isFieldError('notification[title]')}<span class="caption error">{$validator->getFieldError('notification[title]')}</span>{/if}
    </div>
</div>
<div class="field{$validator->isFieldRequired('notification[content]', ' required')} {$validator->isFieldError('notification[content]', ' error')}">
    <div class="label">
        {form->caption name="notification[content]" value="Содержимое"}
    </div>
    <div class="text">
        <span class="caption"><a href="javascript: toggleEditor('contentArea');" id="contentArea_editorStatus" style="text-decoration: none; border-bottom: 1px dashed #aaa;">Включить WYSIWYG-редактор</a></span>
    </div>
        <div class="text">    {form->textarea  name="notification[content]" size="30" id="contentArea" value=$notification->getContent()|h}
        {if $validator->isFieldError('notification[content]')}<span class="caption error">{$validator->getFieldError('notification[content]')}</span>{/if}
    </div>
</div>
<div class="field{$validator->isFieldRequired('notification[date_start]', ' required')} {$validator->isFieldError('notification[date_start]', ' error')}">
    <div class="label">
        {form->caption name="notification[date_start]" value="Дата начала"}
    </div>
    <div class="text">
        {$date_start="d.m.Y H:i"|date:time()}
        {form->text name="notification[date_start]" size="30" value=$notification->getDateStart()|default:$date_start}
        {if $validator->isFieldError('notification[date_start]')}<span class="caption error">{$validator->getFieldError('notification[date_start]')}</span>{/if}
    </div>
</div>
<div class="field{$validator->isFieldRequired('notification[date_end]', ' required')} {$validator->isFieldError('notification[date_end]', ' error')}">
    <div class="label">
        {form->caption name="notification[date_end]" value="Конечная дата"}
    </div>
    <div class="text">
        {$date_end_time_stamp=time()+15*60}
        {$date_end="d.m.Y H:i"|date:$date_end_time_stamp}
        {form->text name="notification[date_end]" size="30" value=$notification->getDateEnd()|default:$date_end}
        {if $validator->isFieldError('notification[date_end]')}<span class="caption error">{$validator->getFieldError('notification[date_end]')}</span>{/if}
    </div>
</div>
<div class="field buttons">
    <div class="text">
        {form->submit name="submit" value="_ simple/save"} {form->reset jip=true name="reset" value="_ simple/cancel"}
    </div>
</div>
</form>
<script>
    $('#formElm_notification_date_end').datetimepicker({
        dateFormat: 'dd.mm.yy',
        hour: {"H"|date:$date_end_time_stamp},
        minute: {"i"|date:$date_end_time_stamp}

    });
    $('#formElm_notification_date_start').datetimepicker({
        dateFormat: 'dd.mm.yy',
        hour: {"H"|date},
        minute: {"i"|date}
});
</script>