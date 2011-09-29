<span id="topLogin" class="f-right">
{form action=$form_action method="post"}
{_ login} > 
    {form->hidden name="url" id="backUrlField" value=$backURL}
    <label for="loginField">{_ username}</label>
    {form->text name="login" size=10 style="width: 135px;" id="loginField"}
    <label for="passwordField">{_ password}</label>
    {form->password name="password" size=10 style="width: 135px;" id="passwordField"}
    {form->hidden name="save" id="saveLogin" value="1"}
    {form->hidden name="url" value={url}}
    {form->submit name="submit" value="_ login_process"}
</form>
</span>