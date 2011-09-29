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

fileLoader::load('user/models/notificationConfig');

/**
 * notificationConfigMapper
 *
 * @package modules
 * @subpackage user
 * @version 0.0.1
 */
class notificationConfigMapper extends mapper
{
    /**
     * DomainObject class name
     *
     * @var string
     */
    protected $class = 'notificationConfig';

    /**
     * Table name
     *
     * @var string
     */
    protected $table = 'user_notificationConfig';

    /**
     * Map
     *
     * @var array
     */
    protected $map = array(
        'id' => array(
            'accessor' => 'getId',
            'mutator' => 'setId',
            'options' => array(
                'pk')),
         'user_id' => array(
            'accessor' => 'getUser',
            'mutator' => 'setUser',
            'relation' => 'one',
            'mapper' => 'user/user',
            'local_key' => 'user_id',
            'foreign_key' => 'id'
        ),

        'event' => array(
            'accessor' => 'getEvent',
            'mutator' => 'setEvent',
        )
        );

    public function searchByEvent($event)
    {
        return $this->searchAllByField('event', $event->getName());
    }
}

?>