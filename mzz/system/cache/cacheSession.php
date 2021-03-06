<?php
/**
 * $URL: svn://svn.mzz.ru/mzz/trunk/system/cache/cacheSession.php $
 *
 * MZZ Content Management System (c) 2006
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @package system
 * @subpackage cache
 * @version $Id: cacheSession.php 3805 2009-10-14 05:41:05Z zerkms $
 */

/**
 * cacheSession: session cache driver
 *
 * @package system
 * @subpackage cache
 * @version 0.0.1
 */

class cacheSession extends cacheBackend
{
    /**
     * Session object
     *
     * @var object
     */
    private $session;

    /**
     * Key for _SESSION array
     *
     * @var unknown_type
     */
    private $session_key;

    private $expire = 60;

    /**
     * Constructor
     *
     * @param $params cache parameters
     */
    public function __construct(Array $params)
    {
        $this->session_key = (isset($params['session_key'])) ? $params['session_key'] : '__cache';
        $this->session = systemToolkit::getInstance()->getSession();

        if (isset($params['expire'])) {
            $this->expire = $params['expire'];
        }
    }

    public function set($key, $value, $expire = null)
    {
        if (is_null($expire)) {
            $expire = $this->expire;
        }

        $data = array(
            'value' => $value,
            'created' => time(),
            'expire' => $expire);

        $this->session->set($this->getSessionKey($key), $data);
        return true;
    }

    public function get($key)
    {
        $data = $this->getCacheData($key);
        if ($data) {
            $expire = (int)$data['expire'];
            $created = (int)$data['created'];
            if (($created + $expire) > time()) {
                return $data['value'];
            } else {
                $this->delete($key);
            }
        }

        return null;
    }

    public function delete($key, $params = array())
    {
        return $this->session->destroy($this->getSessionKey($key));
    }

    public function flush($params = array())
    {
        $this->session->destroy($this->session_key);
        return true;
    }

    protected function getCacheData($key)
    {
        $sessionKey = $this->getSessionKey($key);
        $data = $this->session->get($sessionKey);
        if (is_array($data) && isset($data['value'], $data['expire'], $data['created'])) {
            return array(
                'value' => $data['value'],
                'created' => $data['created'],
                'expire' => $data['expire']);
        }

        return null;
    }

    protected function getSessionKey($key)
    {
        return $this->session_key . '[' . $key . ']';
    }
}

?>