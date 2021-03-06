<?php
/**
 * $URL: svn://svn.mzz.ru/mzz/trunk/system/template/drivers/nativeTemplate.php $
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
 * @version $Id: nativeTemplate.php 4211 2010-04-30 05:30:35Z striker $
 */

fileLoader::load('template/drivers/native/aNativePlugin');

/**
 * Native templates driver
 *
 * @package system
 * @subpackage template
 * @version 0.1.0
 */
class nativeTemplate extends aTemplate {
    /**
     * @var array
     */
    protected $plugins = array();
    protected $wrapStack = array();

    public function __construct(view $view)
    {
        parent::__construct($view);
        $this->assign_by_ref('__form', new form());
    }

    /**
     * Render template
     *
     * @param string $resource template file name
     * @return mixed
     */
    public function render($__resource__, array $__data__ = array()) {
        if (file_exists(systemConfig::$pathToApplication . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . $__resource__)) {
           $__filePath__ = systemConfig::$pathToApplication . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . $__resource__;
        }

        if (empty($__filePath__)) {
            $__filePath__ = fileLoader::resolve($__resource__);
        }

        if (empty($__filePath__)) {
            throw new mzzIoException($__resource__);
        }

        extract($this->view->export(), EXTR_REFS);

        extract($__data__, EXTR_OVERWRITE);
        unset($__data__);

        ob_start();

        require $__filePath__;
        return ob_get_clean();
    }

    /**
     * Magic method to access plugins
     *
     * @param string $plugin name
     * @param array $arguments to pass
     * @return mixed
     */
    public function __call($plugin, array $arguments) {
        //var_dump($arguments); die();
        $plugin = strtolower($plugin);
        if (!isset($this->plugins[$plugin])) {
            $class = $plugin . 'NativePlugin';
            fileLoader::load('template/drivers/native/' . $class);
            if (class_exists($class)) {
                $this->plugins[$plugin] = new $class($this, $this->view);
            } else {
                throw new mzzRuntimeException("plugin " . $plugin . " not found");
            }
        }

        return call_user_func_array(array($this->plugins[$plugin], 'run'), $arguments);
    }

    /**
     * Add function to load css/js files, alias for internal addMedia
     *
     * @param string|array $files of files to load
     * @param bool $join use external to join files or not
     * @param string $template to use when loading file
     */
    public function add($files, $join = true, $template = null) {
        $this->view->plugin('add', array('file' => $files, 'join' => $join, 'tpl' => $template));
    }

    /**
     *
     * @param string|null $tpl
     * @param string $placeholder
     */
    public function wrap($tpl = null, $placeholder = 'content')
    {
        if (empty($tpl)) {
            $wrap = array_pop($this->wrapStack);
            if ($wrap) {
                $content = ob_get_clean();
                echo $this->render($wrap['tpl'], array($wrap['placeholder'] => $content));
            }
        } else {
            array_push($this->wrapStack, array('tpl' => $tpl, 'placeholder' => $placeholder));
            ob_start();
        }
    }

    /**
     * shortcut for view::assign()
     *
     * @param string|array $variable variable name or array of variables
     * @param mixed $value to assign
     */
    public function assign($variable, $value = null)
    {
        $this->view->assign($variable, $value);
    }

    /**
     * shortcut for view::assign_by_ref()
     *
     * @param string $variable variable name
     * @param mixed $value to assign
     */
    public function assign_by_ref($variable, &$value)
    {
        $this->view->assign_by_ref($variable, $value);
    }

    public function truncate_string($string, $length = 80, $etc = '...', $break_words = false, $middle = false)
    {
        if ($length == 0) {
            return '';
        }

        if (mzz_strlen($string) > $length) {
            $length -= min($length, mzz_strlen($etc));
            if (!$break_words && !$middle) {
                $string = preg_replace('/\s+?(\S+)?$/u', '', mzz_substr($string, 0, $length + 1));
            }
            if (!$middle) {
                return mzz_substr($string, 0, $length) . $etc;
            } else {
                return mzz_substr($string, 0, $length / 2) . $etc . mzz_substr($string, - $length / 2);
            }
        } else {
            return $string;
        }
    }
}
?>