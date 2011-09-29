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

fileLoader::load('notification/models/read');

/**
 * readMapper
 *
 * @package modules
 * @subpackage notification
 * @version 0.0.1
 */
class readMapper extends mapper
{
    /**
     * DomainObject class name
     *
     * @var string
     */
    protected $class = 'read';

    /**
     * Table name
     *
     * @var string
     */
    protected $table = 'notification_readed';

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
        'notif_id' => 
        array (
            'accessor' => 'getNotifId',
            'mutator' => 'setNotifId',
            'type' => 'int',
            'range' => 
            array (
                0 => 0,
                1 => 4294967296,
            ),
        ),
        'user_id' => 
        array (
            'accessor' => 'getUserId',
            'mutator' => 'setUserId',
            'type' => 'int',
            'range' => 
            array (
                0 => 0,
                1 => 4294967296,
            ),
        ),
    );
    
    public function read($notif_id)
    {
        $criteria = new criteria;
        $criterion = new criterion('notif_id', $notif_id);
        $criterion->addAnd(new criterion('user_id', systemToolkit::getInstance()->getUser()->getId()));
        $criteria->where($criterion);
        $notif_read = $this->searchOneByCriteria($criteria);
        if(!$notif_read) {
            $notif_read = $this->create();
            $notif_read->setUserId(systemToolkit::getInstance()->getUser()->getId());
            $notif_read->setNotifId($notif_id);
            $this->save($notif_read);
        }
    }
}

?>