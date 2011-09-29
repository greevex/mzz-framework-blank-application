{add file="privateMessage/privateMessage.css"}
{add file="privateMessage/privateMessage.js"}
<div id="privateMessage">
    <div id="privateMessage_mainWindow">
        <div id="privateMessage_mainWindow_title">
            <span id="privateMessage_mainWindow_close">[↓]</span>
            Общение с пользователями
        </div>
        <div id="privateMessage_mainWindow_contactList">
            {foreach item="contact" from=$contacts}
            <a href="#userProfile{$contact->getId()}" class="privateMessage_contactList_contact">
                <span class="privateMessage_chat_userName">{$contact->getName()|truncate:20:""}</span>
            </a>
            {/foreach}
        </div>
    </div>

    <div id="privateMessage_chatWindow">
        <div id="privateMessage_chatWindow_title">
            <span id="privateMessage_chatWindow_close">[X]</span>
            Переписка с пользователем <span id="privateMessage_chatWindow_username">:)</span>
        </div>
        <div id="privateMessage_chatWindow_messageList">
        </div>
        <div id="privateMessage_chatWindow_writeBlock">
            <textarea></textarea>
        </div>
    </div>
</div>