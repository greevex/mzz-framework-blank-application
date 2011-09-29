<?php
/**
 * $URL: svn://svn.mzz.ru/mzz/trunk/system/modules/admin/templates/generator/do.tpl $
 *
 * MZZ Content Management System (c) 2011
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: do.tpl 4004 2009-11-24 00:10:39Z mz $
 */

/**
 * privateMessageRoom
 * generated with mzz scaffolding
 *
 * @package modules
 * @subpackage privateMessage
 * @version 0.0.1
 */
class privateMessageRoom extends entity
{
    /**
    * Get messages by room
    *
    * @param int $limit
    * @param bool $as_array - by default as Collection
    */
    public function getMessages($limit = 20, $as_array = false)
    {
        $msgMapper = systemToolkit::getInstance()->getMapper('privateMessage', 'privateMessage');
        $criteria = new criteria;
        $criteria->orderByDesc('date');
        $criteria->limit($limit);
        $criteria->where('room_id', $this->getRoomId());
        $msgs = $msgMapper->searchAllByCriteria($criteria);
        $this->update();
        if($as_array) {
            $messages = array();
            foreach($msgs as $msg) {
                $messages[$msg->getId()]['user']['id'] = $msg->getUser()->getId();
                $messages[$msg->getId()]['user']['login'] = $msg->getUser()->getLogin();
                $messages[$msg->getId()]['msg_id'] = $msg->getId();
                $messages[$msg->getId()]['text'] = $msg->getText();
                $messages[$msg->getId()]['room_id'] = $msg->getRoomId();
                $date = explode(' ', $msg->getDate());
                $messages[$msg->getId()]['date'] = $date['0'];
                $messages[$msg->getId()]['time'] = $date['1'];
            }
        }
        return $as_array ? $messages : $msgs;
    }

    /**
    * Get new messages
    *
    * @param bool $as_array
    * @return bool
    */
    public function getNewMessages($as_array = false)
    {
        $msgMapper = systemToolkit::getInstance()->getMapper('privateMessage', 'privateMessage');
        $criteria = new criteria;
        $criterion = new criterion('room_id', $this->getRoomId());
        $criterion->addAnd(new criterion('date', $this->getLastSeen(), criteria::GREATER_EQUAL));
        $criteria->orderByDesc('date');
        $criteria->where($criterion);
        $msgs = $msgMapper->searchAllByCriteria($criteria);
        $this->update();
        if($as_array) {
            $messages = array();
            foreach($msgs as $msg) {
                $messages[$msg->getId()]['user']['id'] = $msg->getUser()->getId();
                $messages[$msg->getId()]['user']['login'] = $msg->getUser()->getLogin();
                $messages[$msg->getId()]['msg_id'] = $msg->getId();
                $messages[$msg->getId()]['text'] = $msg->getText();
                $messages[$msg->getId()]['room_id'] = $msg->getRoomId();
                $date = explode(' ', $msg->getDate());
                $messages[$msg->getId()]['date'] = $date['0'];
                $messages[$msg->getId()]['time'] = $date['1'];
            }
        }
        return $as_array ? $messages : $msgs;
    }

    /**
    * Update last_seen timestamp
    *
    */
    public function update()
    {
        $msgRoomMapper = systemToolkit::getInstance()->getMapper('privateMessage', 'privateMessageRoom');
        $this->setLastSeen(new sqlFunction('NOW'));
        $msgRoomMapper->save($this);
    }
}
?>