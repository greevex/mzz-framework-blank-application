<?php


class appToolkit extends stdToolkit
{
    public function setUser($user)
    {
        $toolkit = systemToolkit::getInstance();
        $userMapper = $toolkit->getMapper('user', 'user');
        if (is_numeric($user)) {
            $user = $userMapper->searchByKey($user);
        }

        if (empty($user)) {
            $user = $userMapper->getGuest();
        }

        $toolkit->getSession()->set('user_name', $user->getName());
        parent::setUser($user);
    }
}
