<?php

/**
 * $URL: svn://svn.mzz.ru/mzz/trunk/system/core/loadDispatcher.php $
 *
 * MZZ Content Management System (c) 2006
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @package system
 * @subpackage template
 * @version $Id: loadDispatcher.php 4410 2011-06-21 07:47:13Z striker $
 */

/**
 * loadDispatcher: dispatches load params to a controller of a module
 *
 * @package system
 * @subpackage core
 * @version 0.1
 */
class loadDispatcher
{

    /**
     * Request
     *
     * @var iRequest
     */
    protected static $request;

    /**
     * Dispatch load params to a controller
     *
     * @param string $module
     * @param string $actionName
     * @param array $params
     * @return string|null
     */
    static public function dispatch($moduleName, $actionName, $params = array())
    {
        if (empty($moduleName)) {
            throw new mzzRuntimeException("Module loading error: the name of the module is not specified.");
        }

        $toolkit = systemToolkit::getInstance();

        $module = $toolkit->getModule($moduleName);
        if ($module->isEnabled()) {
            $action = $module->getAction($actionName);
            // prepare request
            $request = $toolkit->getRequest();
            $request->save();
            $request->setModule($moduleName);
            $request->setAction($actionName);

            foreach ($params as $name => $value) {
                $request->setParam($name, $value);
            }
            if (empty(self::$request)) {
                self::$request = $request;
            }

            try {
                $mapper = $module->getMapper($action->getClassName());
            } catch (mzzIoException $ex) {
                $mapper = null;
            }

            if ($mapper) {
                if ($mapper instanceof iACLMapper) {
                    $object = $mapper->convertArgsToObj(self::$request->getParams());
                    $action->setObject($object);
                }
            }

            // run action if we have access
            if ($action->canRun()) {
                $view = $action->run();
            } else {
                $errorModule = $toolkit->getModule('errorPages');
                $errorAction = $errorModule->getAction('error403');

                $view = $errorAction->run($action);

                /*
                try {
                    $errorAction = $module->getAction($action->getClassName() . '403');
                } catch (mzzUnknownModuleActionException $e) {
                    $errorModule = $toolkit->getModule('errorPages');
                    $errorAction = $errorModule->getAction('error403');
                }
                */
            }

            $request->restore();

            // отдаём контент
            return $view;
        } else {
            if (!DEBUG_MODE) {
                $errorModule = $toolkit->getModule('errorPages');
                $errorAction = $errorModule->getAction('error404');
                return $errorAction->run();
            } else {
                throw new mzzRuntimeException('Module "' . $module->getName() . '" is not enabled. Check systemConfig::$enabledModules in config.php');
            }
        }
    }
}
?>