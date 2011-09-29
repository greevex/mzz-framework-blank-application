<?php
/**
 * $URL: svn://svn.mzz.ru/mzz/trunk/system/modules/admin/templates/generator/mapper.tpl $
 *
 * MZZ Content Management System (c) 2010
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: mapper.tpl 4004 2009-11-24 00:10:39Z mz $
 */

fileLoader::load('blog/models/watch');

/**
 * watchMapper
 *
 * @package modules
 * @subpackage blog
 * @version 0.0.1
 */
class watchMapper extends mapper
{
    /**
     * DomainObject class name
     *
     * @var string
     */
    protected $class = 'watch';

    /**
     * Table name
     *
     * @var string
     */
    protected $table = 'blog_watch';

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
                0 => -2147483647,
                1 => 2147483648,
            ),
            'options' => 
            array (
                0 => 'pk',
                1 => 'once',
            ),
        ),
        'name' => 
        array (
            'accessor' => 'getName',
            'mutator' => 'setName',
            'type' => 'varchar',
            'maxlength' => 256,
        ),
        'enabled' => 
        array (
            'accessor' => 'getEnabled',
            'mutator' => 'setEnabled',
            'type' => 'int',
            'range' => 
            array (
                0 => -2147483647,
                1 => 2147483648,
            ),
        ),
        'jip' => 
        array (
            'accessor' => 'getJip',
            'options' => 
            array (
                0 => 'fake',
                1 => 'ro',
            ),
        ),
        'lastUpdate' => 
        array (
            'accessor' => 'getLastUpdate',
            'mutator' => 'setLastUpdate',
            'type' => 'int',
            'range' => 
            array (
                0 => -2147483647,
                1 => 2147483648,
            ),
        ),
    );
    
    public function getEnabledModules()
    {
        $criteria = new criteria;
        $criteria->where('enabled', '1');
        return $this->searchAllByCriteria($criteria);
    }
    
    public function __construct($module)
    {
        parent::__construct($module);
        $this->plugins('jip');
    }
}

?>