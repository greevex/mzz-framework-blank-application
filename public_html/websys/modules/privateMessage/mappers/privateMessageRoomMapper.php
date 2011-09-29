<?php
/**
 * $URL: svn://svn.mzz.ru/mzz/trunk/system/modules/admin/templates/generator/mapper.tpl $
 *
 * MZZ Content Management System (c) 2011
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: mapper.tpl 4004 2009-11-24 00:10:39Z mz $
 */

fileLoader::load('privateMessage/models/privateMessageRoom');

/**
 * privateMessageRoomMapper
 *
 * @package modules
 * @subpackage privateMessage
 * @version 0.0.1
 */
class privateMessageRoomMapper extends mapper
{
    /**
     * DomainObject class name
     *
     * @var string
     */
    protected $class = 'privateMessageRoom';

    /**
     * Table name
     *
     * @var string
     */
    protected $table = 'privateMessage_privateMessageRoom';

    /**
     * Map
     *
     * @var array
     */
    protected $map = array (
        'id' => 
        array (
            'accessor' => 'getId',
            'mutator' => 'setId',
            'type' => 'int',
            'range' => 
            array (
                0 => 0,
                1 => 4294967296,
            ),
            'options' => 
            array (
                0 => 'pk',
                1 => 'once',
            ),
        ),
        'room_id' => 
        array (
            'accessor' => 'getRoomId',
            'mutator' => 'setRoomId',
            'type' => 'int',
            'range' => 
            array (
                0 => 0,
                1 => 4294967296,
            ),
        ),
        'user_id' => 
        array (
            'accessor' => 'getUser',
            'mutator' => 'setUser',
            'relation' => 'one',
            'mapper' => 'user/user',
            'foreign_key' => 'id',
        ),
        'last_seen' => 
        array (
            'accessor' => 'getLastSeen',
            'mutator' => 'setLastSeen',
            'type' => 'timestamp',
        ),
    );
    
    public function checkRoom($room_id, $user_id = null)
    {
        if($user_id == null) {
            $user_id = systemToolkit::getInstance()->getUser()->getId();
        }
        $criterion = new criterion('room_id', $room_id);
        $criterion->addAnd(new criterion('user_id', $user_id));
        $criteria = new criteria;
        $criteria->where($criterion);
        $room = $this->searchOneByCriteria($criteria);
        if(!$room) {
            $room = $this->create();
            $room->setUser($user_id);
            $room->setRoomId($room_id);
            $this->save($room);
        }
        return $room;
    }
    
    /**
    * Get room by array with user's IDs
    * 
    * @param array $users
    */
    public function getRoom($users = array()) {
        $result = false;
        if(count($users) !== false) {
            $db = fDB::factory();
            $users_string = implode(',', $users);
            $sql = "SELECT
                        `room_id`
                    FROM
                        `privateMessage_privateMessageRoom`
                    WHERE `user_id` IN ({$users_string})
                    GROUP BY `room_id`
                    HAVING COUNT(`room_id`) = " . count($users);
            $data = $db->getRow($sql);
            if(!isset($data['room_id'])) {
                $sql = "SELECT MAX(`room_id`) as `room_id` FROM `privateMessage_privateMessageRoom`";
                $data = $db->getRow($sql);
                if(!isset($data['room_id'])) {
                    $data = array('room_id' => 1);
                } else {
                    $data['room_id']++;
                }
                foreach($users as $user_id) {
                    $room = $this->checkRoom($data['room_id'], $user_id);
                }
                $result = $room;
            } else {
                $result = $this->checkRoom($data['room_id']);
            }
        }
        return $result;
    }
}

?>