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

fileLoader::load('process/models/processTask');

/**
 * processTaskMapper
 *
 * @package modules
 * @subpackage process
 * @version 0.0.1
 */
class processTaskMapper extends mapper
{
    /**
     * DomainObject class name
     *
     * @var string
     */
    protected $class = 'processTask';

    /**
     * Table name
     *
     * @var string
     */
    protected $table = 'process_processTask';

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
        'method' =>
        array (
            'accessor' => 'getMethod',
            'mutator' => 'setMethod',
            'type' => 'varchar',
            'maxlength' => 10,
        ),
        'name' =>
        array (
            'accessor' => 'getName',
            'mutator' => 'setName',
            'type' => 'varchar',
            'maxlength' => 255,
        ),
        'parent_id' =>
        array (
            'accessor' => 'getParentId',
            'mutator' => 'setParentId',
            'type' => 'int',
            'range' =>
            array (
                0 => -2147483647,
                1 => 2147483648,
            ),
        ),
        'order' =>
        array (
            'accessor' => 'getOrder',
            'mutator' => 'setOrder',
            'type' => 'int',
            'range' =>
            array (
                0 => -2147483647,
                1 => 2147483648,
            ),
        ),
    );
    public function searchAllGroups()
    {
        $criteria = new criteria;
        $criteria->where('parent_id', null, criteria::IS_NULL);
        $criteria->orderByAsc('order');
        return $this->searchAllByCriteria($criteria);
    }

    public function getNextOrderForGroup($id)
    {
        return $this->db()->getOne("SELECT IF (`order` IS NULL, 0, MAX(`order`) + 1) FROM {$this->table(true)} WHERE `parent_id` = " . (int)$id);
    }

    public function preInsert(array &$data)
    {
        if (empty($data['order']) && isset($data['parent_id'])) {
            $data['order'] = $this->getNextOrderForGroup($data['parent_id']);
        }
    }

    public function preDelete(entity $object)
    {
        $subtasks = $this->searchAllByField('parent_id', $object->getId());
        foreach ($subtasks as $subtask) {
            $this->delete($subtask);
        }
    }

    public function deleteRelation($object)
    {
        $schedulerTaskMapper = systemToolkit::getInstance()->getMapper('scheduler', 'schedulerTask');
        $scheduled_tasks = $schedulerTaskMapper->searchAllTasksById($object->getId());

        foreach ($scheduled_tasks as $scheduled_task) {
            $schedulerTaskMapper->delete($scheduled_task);
        }
    }
}

?>