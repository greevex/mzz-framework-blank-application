<?php
/**
 * $URL: svn://svn.mzz.ru/mzz/trunk/system/exceptions/mzzInvalidParameterException.php $
 *
 * MZZ Content Management System (c) 2006
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @package system
 * @subpackage exceptions
 * @version $Id: mzzInvalidParameterException.php 2901 2009-01-01 13:54:41Z mz $
*/

/**
 * mzzInvalidParameterException
 *
 * @package system
 * @subpackage exceptions
 * @version 0.2
*/
class mzzInvalidParameterException extends mzzException
{

    /**
     * Конструктор
     *
     * @param string $message
     * @param mixed $param
     * @param integer $code
     */
    public function __construct($message, $param = null, $code = 0)
    {
        parent::__construct($message, $code);
        $this->setName('Invalid Parameter');
    }

}

?>