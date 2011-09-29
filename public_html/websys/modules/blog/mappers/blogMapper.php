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

fileLoader::load('blog/models/blog');

/**
 * blogMapper
 *
 * @package modules
 * @subpackage blog
 * @version 0.0.1
 */
class blogMapper extends mapper
{
    /**
     * DomainObject class name
     *
     * @var string
     */
    protected $class = 'blog';

    /**
     * Table name
     *
     * @var string
     */
    protected $table = 'blog_blog';

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
        'author' => 
        array (
            'accessor' => 'getAuthorId',
            'mutator' => 'setAuthor',
            'type' => 'int',
            'range' => 
            array (
                0 => -2147483647,
                1 => 2147483648,
            ),
        ),
        'date' => 
        array (
            'accessor' => 'getDate',
            'mutator' => 'setDate',
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
        'lookup' => 
        array (
            'accessor' => 'getLookup',
            'mutator' => 'setLookup',
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
            'maxlength' => 256,
        ),
        'sticky' => 
        array (
            'accessor' => 'getSticky',
            'mutator' => 'setSticky',
            'type' => 'int',
            'range' => 
            array (
                0 => -2147483647,
                1 => 2147483648,
            ),
        ),
        'stickyDate' => 
        array (
            'accessor' => 'getStickyDate',
            'mutator' => 'setStickyDate',
            'type' => 'int',
            'range' => 
            array (
                0 => -2147483647,
                1 => 2147483648,
            ),
        ),
    );
	
	public function __construct($module)
    {
        parent::__construct($module);
        $this->plugins('jip');
    }
}

?>