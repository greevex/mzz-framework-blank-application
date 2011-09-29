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

fileLoader::load('log/models/log');

/**
 * logMapper
 *
 * @package modules
 * @subpackage log
 * @version 0.0.1
 */
class logMapper extends mapper
{
    /**
     * DomainObject class name
     *
     * @var string
     */
    protected $class = 'log';

    /**
     * Table name
     *
     * @var string
     */
    protected $table = 'log_log';

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
            'orderBy' => 1,
            'orderByDirection' => 'desc',
            'range' =>
            array (
                0 => -2147483647,
                1 => 2147483648,
            ),
            'options' =>
            array (
                0 => 'pk',
                1 => 'once',
            ),
        ),
        'time' =>
        array (
            'accessor' => 'getTime',
            'mutator' => 'setTime',
            'type' => 'int',
            'range' =>
            array (
                0 => -2147483647,
                1 => 2147483648,
            ),
        ),
        'module' =>
        array (
            'accessor' => 'getModule',
            'mutator' => 'setModule',
            'type' => 'varchar',
            'maxlength' => 255,
        ),
        'action' =>
        array (
            'accessor' => 'getAction',
            'mutator' => 'setAction',
            'type' => 'varchar',
            'maxlength' => 255,
        ),
        'comment' =>
        array (
            'accessor' => 'getComment',
            'mutator' => 'setComment',
            'type' => 'text',
        ),
        'status' =>
        array (
            'accessor' => 'getStatus',
            'mutator' => 'setStatus',
            'type' => 'int',
            'range' =>
            array (
                0 => -2147483647,
                1 => 2147483648,
            ),
        ),
        'user_id' =>
        array (
            'accessor' => 'getUser',
            'mutator' => 'setUser',
            'type' => 'int',
            'relation' => 'one',
            'mapper' => 'user/user',
            'foreign_key' => 'id',
            'local_key' => 'user_id',
            'range' =>
            array (
                0 => 0,
                1 => 4294967296,
            ),
        ),
        'process_id' =>
        array (
            'accessor' => 'getProcessId',
            'mutator' => 'setProcessId',
            'type' => 'int',
            'range' =>
            array (
                0 => 0,
                1 => 4294967296,
            ),
        ),
    );
}

?>