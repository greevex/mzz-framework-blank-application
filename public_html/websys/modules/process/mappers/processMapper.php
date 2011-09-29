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

fileLoader::load('process/models/process');

/**
 * processMapper
 *
 * @package modules
 * @subpackage process
 * @version 0.0.1
 */
class processMapper extends mapper
{
    /**
     * DomainObject class name
     *
     * @var string
     */
    protected $class = 'process';

    /**
     * Table name
     *
     * @var string
     */
    protected $table = 'process_process';

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
            'orderByDirection' => 'DESC',
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
        'pid' =>
        array (
            'accessor' => 'getPid',
            'mutator' => 'setPid',
            'type' => 'int',
            'range' =>
            array (
                0 => 0,
                1 => 4294967296,
            ),
        ),
        'module' =>
        array (
            'accessor' => 'getModule',
            'mutator' => 'setModule',
            'type' => 'varchar',
            'maxlength' => 100,
        ),
        'action' =>
        array (
            'accessor' => 'getAction',
            'mutator' => 'setAction',
            'type' => 'varchar',
            'maxlength' => 100,
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
        'name' =>
        array (
            'accessor' => 'getName',
            'mutator' => 'setName',
            'type' => 'varchar',
            'maxlength' => 100,
        ),
        'status' =>
        array (
            'accessor' => 'getStatus',
            'mutator' => 'setStatus',
            'type' => 'varchar',
            'maxlength' => 100,
        ),
        'percent' =>
        array (
            'accessor' => 'getPercent',
            'mutator' => 'setPercent',
            'type' => 'float unsigned',
        ),
    );
}

?>