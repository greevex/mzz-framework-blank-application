<div class="jipTitle">Создание новой записи</div>
{literal}<script type="text/javascript">     
fileLoader.loadJS(SITE_PATH + '/js/tiny_mce/jquery.tinymce.js');
fileLoader.loadCSS(SITE_PATH + '/css/calendar-blue.css');
fileLoader.loadJS(SITE_PATH + '/js/jscalendar/calendar.js',
    function(url, type, status){
        if (status == 0 || status == 'success'){
            fileLoader.loadJS(SITE_PATH + '/js/jscalendar/calendar-ru.js');
            fileLoader.loadJS(SITE_PATH + '/js/jscalendar/calendar-setup.js', function() {
                Calendar.setup({
                    'inputField': 'calendar-field-created',
                    'button': 'calendar-trigger-created',
                    'ifFormat': '%d.%m.%Y %H:%M',
                    "firstDay":1,
                    "showsTime":true,
                    "showOthers":true,
                    "timeFormat":24
                });
            });
        }
    }, null, true);
    
(function($) {
    toggleEditor = function(id) {
        if (!(tinyMCE) || tinyMCE.getInstanceById(id) == null) {
            $('#' + id).tinymce({
                script_url: SITE_PATH + '/js/tiny_mce/tiny_mce.js',
                theme : "advanced",
                skin : 'default',
                skin_variant : "",
                mode : "none",
                plugins : "style,advhr,advimage,advlink,iespell,media,directionality,fullscreen,visualchars,nonbreaking,xhtmlxtras",
                language : "ru",
                theme_advanced_buttons1_add : "fontselect,fontsizeselect,ltr,rtl,separator,fullscreen,nonbreaking",
                theme_advanced_buttons2_add : "separator,forecolor,backcolor",
                theme_advanced_toolbar_location : "top",
                theme_advanced_toolbar_align : "left",
                theme_advanced_path_location : "bottom",
                plugin_insertdate_dateFormat : "%Y-%m-%d",
                plugin_insertdate_timeFormat : "%H:%M:%S",
                extended_valid_elements : "hr[class|width|size|noshade],font[face|size|color|style],span[class|align|style]",
                theme_advanced_resize_horizontal : false,
                theme_advanced_resizing : true,
                nonbreaking_force_tab : true,
                apply_source_formatting : true,
                add_unload_trigger : false,
                add_form_submit_trigger: false,
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
	toggleEditor('contentAreaBlog');
})(jQuery);                      
</script>{/literal}
{form action=$action method="post" onsubmit="if (tinyMCE) tinyMCE.triggerSave(true, true);"}
<table class="blog_newpost">
<tr>
    <td>
        {form->caption name="post[title]" value="Название"}
    </td>
</tr>
<tr>
    <td>
        {form->text name="post[title]" value=$title}<br />
        <div class="formError">{$validator->getFieldError('post[title]')}</div>
    </td>
</tr>
<tr>
    <td colspan="2"><span class="caption"><a href="javascript: toggleEditor('contentAreaBlog');" id="contentAreaBlog_editorStatus" style="text-decoration: none; border-bottom: 1px dashed #aaa;">Включить WYSIWYG-редактор</a></span></td>
</tr>
<tr>
    <td>
        {form->caption name="post[content]" value="Содержание"}
    </td>
</tr>
<tr>
    <td>
        {form->textarea name="post[content]" value=$content rows="20" style="width: 100%;" id="contentAreaBlog" cols="50"}
        <div class="formError">{$validator->getFieldError('post[content]')}</div>
    </td>
</tr>
<tr>
    <td>
        {form->caption name="post[lookup]" value="is LookUp Post?"}
    </td>
</tr>
<tr>
    <td>
        {form->checkbox name="post[lookup]" checked=$lookup}
    </td>
</tr>
<tr>
    <td>
        {form->caption name="post[module]" value="Название"}
    </td>
</tr>
<tr>
    <td>
        {form->select name="post[module]" options=$modules value=$module}<br />
        <div class="formError">{$validator->getFieldError('post[module]')}</div>
    </td>
</tr>
<tr>
    <td>
        {form->caption name="post[tags]" value="Теги (через запятую без пробелов)"}
    </td>
</tr>
<tr>
    <td>
        {form->text name="post[tags]"}
    </td>
</tr>
<tr>
    <td>
        {form->caption name="post[sticky]" value="Всегда наверху"}
    </td>
</tr>
<tr>
    <td>
        {form->checkbox name="post[sticky]" checked=$sticky}
    </td>
</tr>
<tr>
    <td>
        {form->caption name="post[stickydate]" value="Дата окончания"}
    </td>
</tr>
<tr>
    <td>
        {form->text name="post[stickydate]" style="width:50%;" id="calendar-field-created" value=$post->getStickyDate()|date_format:"%d.%m.%Y %H:%M"} <button type="button" id="calendar-trigger-created">Открыть календарь</button><br />Текущая дата: {$smarty.now|date_format:"%d.%m.%Y %H:%M"}
        <div class="formError">{$validator->getFieldError('post[stickydate]')}</div>
    </td>
</tr>
<tr>
<td colspan="2">
{form->submit name="submit" value="_ simple/save"} {form->reset jip=true name="reset" value="_ simple/cancel"}
</td>
</tr>
</table>
</form>