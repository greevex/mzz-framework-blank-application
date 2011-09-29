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

fileLoader::load('system/models/feedback');

/**
 * feedbackMapper
 *
 * @package modules
 * @subpackage system
 * @version 0.0.1
 */
class feedbackMapper extends mapper
{
    /**
     * DomainObject class name
     *
     * @var string
     */
    protected $class = 'feedback';

    /**
     * Table name
     *
     * @var string
     */
    protected $table = 'feedback_feedback';

    /**
     * Map
     *
     * @var array
     */
    protected $map = array();
}

?>