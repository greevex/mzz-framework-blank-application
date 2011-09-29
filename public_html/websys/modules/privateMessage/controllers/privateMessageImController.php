<?php
/**
 * $URL: svn://svn.subversion.ru/usr/local/svn/mzz/trunk/system/codegenerator/templates/controller.tpl $
 *
 * MZZ Content Management System (c) 2011
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: controller.tpl 2200 2007-12-06 06:52:05Z zerkms $
 */

/**
 * privateMessageImController
 *
 * @package modules
 * @subpackage privateMessage
 * @version 0.0.1
 */
class privateMessageImController extends simpleController
{
    protected function getView()
    {
        $this->view->disableMain();
        $result = array('status' => false);
        $action = $this->request->getAction();
        $privateMsgMapper = $this->toolkit->getMapper('privateMessage', 'privateMessage');
        $privateMsgRoomMapper = $this->toolkit->getMapper('privateMessage', 'privateMessageRoom');
        if($action != "createRoom") {
            $room_id = $this->request->getInteger('room_id', SC_REQUEST);
            if(!$room_id) {
                return json_encode($result);
            }
            $room = $privateMsgRoomMapper->checkRoom($room_id);
        }
        switch($action)
        {
            case "createRoom":
                $users = $this->request->getArray('users', SC_REQUEST);
                $users[] = $this->toolkit->getUser()->getId();
                $room = $privateMsgRoomMapper->getRoom($users);
                if($room) {
                    $result['room_id'] = $room->getRoomId();
                    $result['status'] = true;
                }
                break;
            case "write":
                $text = $this->request->getString('text', SC_REQUEST);
                if(!$text || empty($text)) {
                    break;
                }
                $msg = $privateMsgMapper->create();
                $msg->setUser($this->toolkit->getUser());
                $msg->setText($text);
                $msg->setRoomId($room->getRoomId());
                $privateMsgMapper->save($msg);
                $result['status'] = true;
                $result['msg_id'] = $msg->getId();
                $result['room_id'] = $room->getRoomId();
                break;
            case "read":
                $messages = $room->getMessages(20, true);
                $result['status'] = true;
                $result['messages'] = $messages;
                $result['room_id'] = $room->getRoomId();
                break;
            case "new":
                $messages = $room->getNewMessages(true);
                $result['status'] = true;
                $result['messages'] = $messages;
                $result['room_id'] = $room->getRoomId();
                break;
        }
        return json_encode($result);
    }
}
?>