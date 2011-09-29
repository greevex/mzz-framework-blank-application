<?php
/**
 * $URL: svn://svn.mzz.ru/mzz/trunk/system/template/plugins/loadPlugin.php $
 *
 * MZZ Content Management System (c) 2010
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @package system
 * @subpackage template
 * @version $Id: loadPlugin.php 4210 2010-04-30 05:10:01Z striker $
 */

fileLoader::load('template/plugins/aPlugin');
fileLoader::load('service/blockHelper');

/**
 * Unified load plugin
 *
 * @package system
 * @subpackage template
 * @version 0.1.0
 */
class loadPlugin extends aPlugin
{
    public function run(array $params)
    {
        $params = new arrayDataspace($params);

        $module = $params['module'];
        $block = $params['_block'];
        $actionName = $params['action'];
        if(!isset($params['title'])) {
            $params['title'] = NULL;
        }
        $title = $params['title'];
        
        $uniqKey = "{$module}_{$actionName}_" . md5(serialize($params->export()));
                                                
        $blockHelper = blockHelper::getInstance();
        if ($block && $blockHelper->isHidden($module . '_' . $actionName)) {
            // loading this action of this module has been disabled by blockHelper
            return null;
        }

        $view = loadDispatcher::dispatch($module, $actionName, $params['params']);
        if(!empty($title)) {
            $view = array('title' => $title, 'view' => $view);
        }

        // отдаём контент в вызывающий шаблон, либо сохраняем его в blockHelper
        if ($block) {
            $blockHelper->set("{$module}_{$actionName}" . md5(is_array($view) ? $view['view'] : $view), $block, $view);
        } else {
            return $view;
        }
    }
}
?>