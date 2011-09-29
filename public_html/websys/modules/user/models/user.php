<?php
/**
 * $URL: svn://svn.mzz.ru/mzz/trunk/system/modules/user/models/user.php $
 *
 * MZZ Content Management System (c) 2005-2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: user.php 4106 2010-02-26 01:29:26Z striker $
 */

fileLoader::load('service/skin');

/**
 * user: user
 *
 * @package modules
 * @subpackage user
 * @version 0.1.6
 */
class user extends entity
{
    /**
     * Проверяет является ли пользователь авторизированным
     * Пользователь считается таковым, если у него установлен
     * id больше 0 и он не равен значению константы MZZ_USER_GUEST_ID
     *
     * @return boolean
     */
    public function isLoggedIn()
    {
        return $this->getId() > 0 && $this->getId() !=  MZZ_USER_GUEST_ID;
    }

    public function isConfirmed()
    {
        return !strlen($this->getConfirmed());
    }

    public function isActive()
    {
        return !is_null($this->getOnline());
    }

    public function getSkin()
    {
        $id = parent::__call('getSkin', array());
        return new skin($id);
    }

    public function isRoot()
    {
        return in_array(MZZ_ROOT_GID, $this->getGroups()->keys());
    }
    
    public function getHash()
    {
        return md5($this->getLogin() . $this->getPassword() . $this->getEmail());
    }
    
    public function inGroup($nameid, $isName = false)
    {
        $result = false;
        if($isName) {
            foreach($this->getGroups() as $group) {
                if($group->getName() == $nameid) {
                    $result = true;
                }
            }
        } else {
            $result = in_array($nameid, $this->getGroups()->keys());
        }
        return $result;
    }
    
    public function checkOnline()
    {
        $toolkit = systemToolkit::getInstance();
        $userOnlineMapper = $toolkit->getMapper('user', 'userOnline');
        if($this->getId() == MZZ_USER_GUEST_ID) {
            $userOnline = $userOnlineMapper->searchOneByField('session', $toolkit->getSession()->getId());
        } else {
            $userOnline = $userOnlineMapper->searchOneByField('user_id', $this->getId());
        }
        if(!$userOnline) {
            $userOnline = $userOnlineMapper->create();                                                 
            $userOnline->setUser($this->getId());
            $userOnline->setSession($toolkit->getSession()->getId());
            if(isset($_SERVER['REMOTE_ADDR'])) {
                $userOnline->setIp($_SERVER['REMOTE_ADDR']);
            }
        }
        $userOnline->setLastActivity(new sqlFunction('UNIX_TIMESTAMP'));
        $userOnline->setUrl($toolkit->getRequest()->getRequestUrl());
        $userOnlineMapper->save($userOnline);
    }
}

?>