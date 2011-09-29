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

fileLoader::load('blog/models/tagsComp');

/**
 * tagsCompMapper
 *
 * @package modules
 * @subpackage blog
 * @version 0.0.1
 */
class tagsCompMapper extends mapper
{
    /**
     * DomainObject class name
     *
     * @var string
     */
    protected $class = 'tagsComp';

    /**
     * Table name
     *
     * @var string
     */
    protected $table = 'blog_tagsComp';

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
        ),
        'postId' => 
        array (
            'accessor' => 'getPostId',
            'mutator' => 'setPostId',
            'type' => 'int',
            'range' => 
            array (
                0 => -2147483647,
                1 => 2147483648,
            ),
        ),
        'tagId' => 
        array (
            'accessor' => 'getTagId',
            'mutator' => 'setTagId',
            'type' => 'int',
            'range' => 
            array (
                0 => -2147483647,
                1 => 2147483648,
            ),
        ),
    );
}

?>