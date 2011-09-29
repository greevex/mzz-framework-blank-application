{if $rules->canRun("update")}
<hr />
{form action={url} method="post" jip=true}
    <pre>
             Сохранить в задание {form->select options=$tasks|default:[] name="parent_task" valueMethod="getName" keyMetod="getId"} {$validator->getFieldError('parent_task')}
        Добавить задание на сайт {form->select multiple=true name="add_site[]" options=$site_options}<br />
                    для проливки {form->select name="add_type" options=$type_options} {$validator->getFieldError('add_type')}<br /> 
               по производителям {form->select name="selected_manufacturers_type" id="selected_manufacturers_type" options=['Все', 'Выбранные']}<br />

         <div id="choose_manufacturer" style="display:none">
            Выбор производителей {form->select multiple="multiple" name="selected_manufacturers[]" options=$manufacturer_select}<br />
         </div>
                    {form->submit name="submit" value="Добавить"}</form>
    </pre>
{/if}
<script>
   $('#selected_manufacturers_type').change(function(){
       if ($(this).val() == 1) {
           $('#choose_manufacturer').show();
       } else {
           $('#choose_manufacturer').hide();
       }
   });
</script>
</form>