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

fileLoader::load('privateMessage/models/privateMessage');

/**
 * privateMessageMapper
 *
 * @package modules
 * @subpackage privateMessage
 * @version 0.0.1
 */
class privateMessageMapper extends mapper
{
    /**
     * DomainObject class name
     *
     * @var string
     */
    protected $class = 'privateMessage';

    /**
     * Table name
     *
     * @var string
     */
    protected $table = 'privateMessage_privateMessage';

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
            'relation' => 'one',
            'mapper' => 'user/user',
            'foreign_key' => 'id',
        ),
        'text' => 
        array (
            'accessor' => 'getText',
            'mutator' => 'setText',
            'type' => 'text',
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
        'date' => 
        array (
            'accessor' => 'getDate',
            'mutator' => 'setDate',
            'type' => 'timestamp'
        ),
    );
}

?>