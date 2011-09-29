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

fileLoader::load('scheduler/models/schedulerTask');

/**
 * schedulerTaskMapper
 *
 * @package modules
 * @subpackage scheduler
 * @version 0.0.1
 */
class schedulerTaskMapper extends mapper
{
    /**
     * DomainObject class name
     *
     * @var string
     */
    protected $class = 'schedulerTask';

    /**
     * Table name
     *
     * @var string
     */
    protected $table = 'scheduler_schedulerTask';

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
        'start_time' =>
        array (
            'accessor' => 'getStartTime',
            'mutator' => 'setStartTime',
            'type' => 'int',
            'range' =>
            array (
                0 => 0,
                1 => 4294967296,
            ),
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
        'command' =>
        array (
            'accessor' => 'getCommand',
            'mutator' => 'setCommand',
            'type' => 'varchar',
            'maxlength' => 255,
        ),
        'parameters' =>
        array (
            'accessor' => 'getParameters',
            'mutator' => 'setParameters',
            'type' => 'varchar',
            'maxlength' => 255,
        ),
        'times_to_run' =>
        array (
            'accessor' => 'getTimesToRun',
            'mutator' => 'setTimesToRun',
            'type' => 'int',
            'range' =>
            array (
                0 => 0,
                1 => 4294967296,
            ),
        ),
        'interval' =>
        array (
            'accessor' => 'getInterval',
            'mutator' => 'setInterval',
            'type' => 'int',
            'range' =>
            array (
                0 => 0,
                1 => 4294967296,
            ),
        ),
        'start_date' =>
        array (
            'accessor' => 'getStartDate',
            'mutator' => 'setStartDate',
            'type' => 'date',
        ),
        'method' =>
        array (
            'accessor' => 'getMethod',
            'mutator' => 'setMethod',
            'type' => 'varchar',
            'maxlength' => 10,
        ),
        'type' =>
        array (
            'accessor' => 'getType',
            'mutator' => 'setType',
            'type' => 'tinyint',
        ),
        'execution_count' =>
        array (
            'accessor' => 'getExecutionCount',
            'mutator' => 'setExecutionCount',
            'type' => 'int',
            'range' =>
            array (
                0 => -2147483647,
                1 => 2147483648,
            ),
        ),
        'last_execution' =>
        array (
            'accessor' => 'getLastExecution',
            'mutator' => 'setLastExecution',
            'type' => 'int',
            'range' =>
            array (
                0 => -2147483647,
                1 => 2147483648,
            ),
        ),
    );

    public function searchAllActive()
    {
        return $this->searchAllByField('status', 1);
    }

    public function searchAllTasksById($id)
    {
        $criteria = new criteria;
        $criteria->where('command', $id);
        $criteria->where('type', 3);
        return $this->searchAllByCriteria($criteria);
    }

    /**
     * Поиск задач, которые были в статусе "в работе" более чем 24 часа, т.к. скорее всего задание
     * было прервано до его завершения.
     *
     * @return collection
     */
    public function searchOldInProgressTasks()
    {
        $criteria = new criteria;
        $criteria->where('status', 3);
        $criteria->where('last_execution', new sqlOperator('-', array(new sqlFunction('UNIX_TIMESTAMP'), 60 * 60 * 24)), criteria::LESS);
        return $this->searchAllByCriteria($criteria);
    }
}

?>