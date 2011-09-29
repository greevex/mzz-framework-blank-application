<div class="jipTitle">
    {if $isEdit}Editing{else}Creating{/if} object notification
</div>

{form action=$form_action method="post" jip=true  class="mzz-jip-form"}
<div class="field{$validator->isFieldRequired('notification[id]', ' required')} {$validator->isFieldError('notification[id]', ' error')}">
    <div class="label">
        {form->caption name="notification[id]" value="id"}
    </div>
    <div class="text">
        {$notification->getId()}
    </div>
</div>
<div class="field{$validator->isFieldRequired('notification[user_id]', ' required')} {$validator->isFieldError('notification[user_id]', ' error')}">
    <div class="label">
        {form->caption name="notification[user_id]" value="user_id"}
    </div>
    <div class="text">
        {form->text name="notification[user_id]" size="30" value=$notification->getUser()}
        {if $validator->isFieldError('notification[user_id]')}<span class="caption error">{$validator->getFieldError('notification[user_id]')}</span>{/if}
    </div>
</div>
<div class="field{$validator->isFieldRequired('notification[title]', ' required')} {$validator->isFieldError('notification[title]', ' error')}">
    <div class="label">
        {form->caption name="notification[title]" value="title"}
    </div>
    <div class="text">
        {form->text name="notification[title]" size="30" value=$notification->getTitle()}
        {if $validator->isFieldError('notification[title]')}<span class="caption error">{$validator->getFieldError('notification[title]')}</span>{/if}
    </div>
</div>
<div class="field{$validator->isFieldRequired('notification[content]', ' required')} {$validator->isFieldError('notification[content]', ' error')}">
    <div class="label">
        {form->caption name="notification[content]" value="content"}
    </div>
    <div class="text">
        {form->text name="notification[content]" size="30" value=$notification->getContent()}
        {if $validator->isFieldError('notification[content]')}<span class="caption error">{$validator->getFieldError('notification[content]')}</span>{/if}
    </div>
</div>
<div class="field{$validator->isFieldRequired('notification[date_start]', ' required')} {$validator->isFieldError('notification[date_start]', ' error')}">
    <div class="label">
        {form->caption name="notification[date_start]" value="date_start"}
    </div>
    <div class="text">
        {form->text name="notification[date_start]" size="30" value=$notification->getDateStart()}
        {if $validator->isFieldError('notification[date_start]')}<span class="caption error">{$validator->getFieldError('notification[date_start]')}</span>{/if}
    </div>
</div>
<div class="field{$validator->isFieldRequired('notification[date_end]', ' required')} {$validator->isFieldError('notification[date_end]', ' error')}">
    <div class="label">
        {form->caption name="notification[date_end]" value="date_end"}
    </div>
    <div class="text">
        {form->text name="notification[date_end]" size="30" value=$notification->getDateEnd()}
        {if $validator->isFieldError('notification[date_end]')}<span class="caption error">{$validator->getFieldError('notification[date_end]')}</span>{/if}
    </div>
</div>
<div class="field buttons">
    <div class="text">
        {form->submit name="submit" value="_ simple/save"} {form->reset jip=true name="reset" value="_ simple/cancel"}
    </div>
</div>
</form>