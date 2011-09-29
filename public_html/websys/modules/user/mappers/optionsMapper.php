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

fileLoader::load('user/models/options');

/**
 * optionsMapper
 *
 * @package modules
 * @subpackage user
 * @version 0.0.1
 */
class optionsMapper extends mapper
{
    /**
     * DomainObject class name
     *
     * @var string
     */
    protected $class = 'options';

    /**
     * Table name
     *
     * @var string
     */
    protected $table = 'user_options';

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
            'accessor' => 'getUserId',
            'mutator' => 'setUserId',
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
            'maxlength' => 128,
        ),
        'action' =>
        array (
            'accessor' => 'getAction',
            'mutator' => 'setAction',
            'type' => 'varchar',
            'maxlength' => 128,
        ),
        'name' =>
        array (
            'accessor' => 'getName',
            'mutator' => 'setName',
            'type' => 'varchar',
            'maxlength' => 128,
        ),
        'serialized_data' =>
        array (
            'accessor' => 'getSerializedData',
            'mutator' => 'setSerializedData',
            'type' => 'text',
        ),
    );


    /**
     * Returns options for the current user, module and action. If options
     * don't exist, a new object is created and returned
     */
    public function searchByNameInCurrentContext($name, $module = null, $action = null, $user_id = false)
    {
        $request = systemToolkit::getInstance()->getRequest();
        $action = empty($action) ? $request->getAction() : $action;
        $module = empty($module) ? $request->getModule() : $module;
        $user_id = $user_id === false ? systemToolkit::getInstance()->getUser()->getId() : $user_id;

        $criteria = new criteria;

        $user_criterion = new criterion('user_id', $user_id);
        $user_criterion->addOr(new criterion('user_id', null, criteria::IS_NULL));

        $criterion = new criterion('module', $module);
        $criterion->addAnd(new criterion("action", $action));
        $criterion->addAnd(new criterion("name", $name));

        $criterion->addAnd($user_criterion);
        $criteria->where($criterion);
        $criteria->orderByDesc('user_id');
        $criteria->limit(1);
        $options = $this->searchOneByCriteria($criteria);

        if (!$options) {
            $options = $this->createForModuleAndAction($module, $action, $user_id);
            $options->setName($name);
        }
        return $options;
    }

    /**
     * Creates a new options object with the currect user, action and module
     */
    public function create()
    {
        return $this->createForModuleAndAction(null, null, false);
    }

    public function createForModuleAndAction($module, $action, $user_id = false)
    {
        $request = systemToolkit::getInstance()->getRequest();
        $action = $action === null ? $request->getAction() : $action;
        $module = $module === null ? $request->getModule() : $module;
        $user_id = $user_id === false ? systemToolkit::getInstance()->getUser()->getId() : $user_id;

        $options = parent::create();
        $options->setAction($action);
        $options->setModule($module);
        $options->setUserId($user_id);
        return $options;
    }
}

?>