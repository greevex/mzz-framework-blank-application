<?php

fileLoader::load('user/models/singleSignOn');

class ssoPamProvider extends aPamProvider
{
    public function login()
    {
        $toolkit = systemToolkit::getInstance();
        $token = $toolkit->getRequest()->getString('token', SC_REQUEST);

        $sso = new singleSignOn();

        $data = $sso->decryptUserData($token);

        if (!isset($data->name) || !isset($data->passwordHash)) {
            return null;
        }
        $login = $data->name;
        $password = $data->passwordHash;

        $userMapper = $toolkit->getMapper('user', 'user');
        $user = $userMapper->searchByLoginAndPasswordHash($login, $password);

        if (!$user || !$user->isConfirmed()) {
            $user = null;
        }

        return $user;
    }

    public function validate(validator &$validator)
    {
        return true;
    }

    public function checkAuth(user $user)
    {
        return ($user->getId() !== MZZ_USER_GUEST_ID &&  $user->isConfirmed());
    }
}
