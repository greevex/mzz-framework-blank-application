<?php
/**
 * $URL: svn://svn.mzz.ru/mzz/trunk/system/modules/comments/plugins/commentsPlugin.php $
 *
 * MZZ Content Management System (c) 2006
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: commentsPlugin.php 4285 2010-08-06 03:50:25Z striker $
*/

/**
 * commentsPlugin: плагин для комментируемых модулей.
 *
 * @package orm
 * @subpackage plugins
 * @version 0.0.2
 */
class commentsPlugin extends observer
{
    protected $options = array(
        'byField' => 'id'
    );

    /*
    public function commentPostInsert(Array $data)
    {
    }
    */

    public function preDelete($object)
    {
        $toolkit = systemToolkit::getInstance();
        $commentsFolderMapper = $toolkit->getMapper('comments', 'commentsFolder');

        $objectClass = get_class($object);

        $map = $this->mapper->map();

        $objectId = $object->$map[$this->getByField()]['accessor']();

        $commentsFolder = $commentsFolderMapper->searchFolder($objectClass, $objectId);
        if ($commentsFolder) {
            $commentsFolderMapper->delete($commentsFolder);
        }
    }

    public function getByField()
    {
        return $this->options['byField'];
    }
}
?>