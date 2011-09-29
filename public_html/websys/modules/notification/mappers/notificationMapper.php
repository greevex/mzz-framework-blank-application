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

fileLoader::load('notification/models/notification');

/**
 * notificationMapper
 *
 * @package modules
 * @subpackage notification
 * @version 0.0.1
 */
class notificationMapper extends mapper
{
    /**
     * DomainObject class name
     *
     * @var string
     */
    protected $class = 'notification';

    /**
     * Table name
     *
     * @var string
     */
    protected $table = 'notification_notification';

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
        'user_id' =>
        array (
            'accessor' => 'getUser',
            'mutator' => 'setUser',
            'mapper' => 'user/user',
            'relation' => 'one',
            'foreign_key' => 'id',
        ),
        'title' =>
        array (
            'accessor' => 'getTitle',
            'mutator' => 'setTitle',
            'type' => 'text',
        ),
        'content' =>
        array (
            'accessor' => 'getContent',
            'mutator' => 'setContent',
            'type' => 'text',
        ),
        'date_start' =>
        array (
            'accessor' => 'getDateStart',
            'mutator' => 'setDateStart',
            'type' => 'int',
            'range' =>
            array (
                0 => 0,
                1 => 4294967296,
            ),
        ),
        'date_end' =>
        array (
            'accessor' => 'getDateEnd',
            'mutator' => 'setDateEnd',
            'type' => 'int',
            'range' =>
            array (
                0 => 0,
                1 => 4294967296,
            ),
        ),
    );


    public function searchUnread($all = false)
    {
        $user_id = systemToolkit::getInstance()->getUser()->getId();
        $criterion =  new criterion('notif_id', 'notification_notification.id', criteria::EQUAL, true);
        if(!$all) {
            $criterion->addAnd(new criterion('notif_read.user_id', $user_id));
        }

        $criteria = new criteria('notification_notification');
        if(!$all) {
            $criteria->join('notification_readed', $criterion, 'notif_read', criteria::JOIN_LEFT);
            $criteria->where('notif_read.notif_id', null, criteria::IS_NULL);
        }
        $criteria->where('date_start', new sqlFunction('UNIX_TIMESTAMP'), criteria::LESS_EQUAL);
        $criteria->where('date_end', new sqlFunction('UNIX_TIMESTAMP'), criteria::GREATER_EQUAL);

        return $all ? $this->searchAllByCriteria($criteria) : $this->searchOneByCriteria($criteria);
    }
}

?>