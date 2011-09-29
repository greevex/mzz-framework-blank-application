<?php
/**
 * $URL: svn://svn.subversion.ru/usr/local/svn/mzz/trunk/system/codegenerator/templates/controller.tpl $
 *
 * MZZ Content Management System (c) 2010
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: controller.tpl 2200 2007-12-06 06:52:05Z zerkms $
 */

/**
 * blogDeactivateController
 *
 * @package modules
 * @subpackage blog
 * @version 0.0.1
 */
class blogDeactivateController extends simpleController
{
    protected function getView()
    {
        $id = $this->request->getInteger('id');
            
        $watchMapper = $this->toolkit->getMapper('blog', 'watch');
        $m = $watchMapper->searchByKey($id);
        if(!$m) {
            return $this->forward404();
        }
        $m->setEnabled(0);
        $watchMapper->save($m);
        
        return jipTools::refresh();
    }
}
?>