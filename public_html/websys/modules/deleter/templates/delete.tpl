<div class="confirm">
<div class="confirmImg">
<img src="{$SITE_PATH}/images/confirm.gif" hspace="20" vspace="5" /></div>
<div class="confirmMsg">Вы действительно хотите удалить объект типа {$module}_{$class} с {$field} = {$value} ?<br />
{form action=$url method=$method jip=true}
{form->hidden name="confirm" value=$confirm_code}
{if isset($postData)}
    {foreach from=$postData item="hidden"}
        {form->hidden value=$hidden[1] name=$hidden[0]}
    {/foreach}
{/if}
<div>
Выберите как удалить объект: {form->select name="deletion_type" options=[1=>"Удалить только объект", 2 => "Удалить только связи (не удалять сам объект)", 3 => "Удалить объект и его связи"]}
</div>{form->submit name="submit" value="_ yes" accesskey="y"} <span>{form->reset jip=true value="_ no" name="reset" accesskey="n"}</span>
</form>
</div>
<br />
<br />
<br />
<br />
<br />
</div>
<div class="clearfix clear"></div>