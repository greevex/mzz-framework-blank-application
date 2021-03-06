<?php
/**
 * $URL: svn://svn.mzz.ru/mzz/trunk/system/forms/validators/formUrlRule.php $
 *
 * MZZ Content Management System (c) 2005-2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: formUrlRule.php 3870 2009-10-21 05:17:11Z zerkms $
 */

fileLoader::load('forms/validators/formHostnameRule');

/**
 * formUrlRule: правило, проверяющее правильность URL
 *
 * @package system
 * @subpackage forms
 * @version 0.1
 */
class formUrlRule extends formHostnameRule
{
    protected function _validate($value)
    {
        $pattern = '#^((https?|ftps?)://)?(?P<domain>[-A-Z0-9.]+)(:[0-9]{2,4})?(/[-A-Z0-9+&@\#/%=~_|!:,.;]*)?(\?[-A-Z0-9+&@\#/%=~_|!:,.;]*)?$#i';

        if(!preg_match($pattern, $value, $matches)) {
            return false;
        }

        $value = $matches['domain'];
        return parent::_validate($value);
    }
}

?>