<div>

    {form action="{url}" method="post" jip=true}
    Сохранить в задание {form->select options=$tasks|default:[] name="parent_task" valueMethod="getName" keyMetod="getId"}
    {form->text type="hidden" name="go" value="1"}
    {form->select name="site_id" options=$sites}<br /><br />
    {form->submit name="submit" value="Добавить задачу"}
</form>