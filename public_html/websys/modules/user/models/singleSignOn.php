<?php

class UserData
{
    public $name;
    public $passwordHash;
}

class singleSignOn
{
    private $api_key = "4e3b9ad1a9651-4e3b9ad1a9693";
    private $app_key = "1";

    public function generateToken()
    {
       $user = new UserData();
       $date = new DateTime(null, new DateTimeZone('UTC'));
       $user->name = 'RobotProlivshik';
       $user->passwordHash = 'aafe06e46da6f8158e7a90926b1b7a84';
       $encrypted_data = $this->encryptUserData($user);
       return $encrypted_data;
    }

    private function encryptUserData($user_data)
    {
        $app_key = $this->app_key;
        $api_key = $this->api_key;
        $json = json_encode($user_data);

        $salted = $api_key . $app_key;
        $saltedHash = substr(sha1($salted, true), 0, 16);

        $pad = 16 - (strlen($json) % 16);
        $data = $json . (str_repeat(chr($pad), $pad));

        if (!function_exists('mcrypt_encrypt'))
            throw new Exception('Mcrypt extension is not installed for PHP.');
        $aes = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $saltedHash, $data, MCRYPT_MODE_CBC, str_repeat("\0", 16));

        $b64token = base64_encode($aes);
        $b64token = rtrim(str_replace(array('+', '/'), array('-', '_'), $b64token), '=');

        return $b64token;
    }

    public function decryptUserData($token)
    {
        $b64token = str_replace(array('-', '_'), array('+', '/'), $token);
        $data = base64_decode($b64token);

        $app_key = $this->app_key;
        $api_key = $this->api_key;

        $salted = $api_key . $app_key;
        $saltedHash = substr(sha1($salted, true), 0, 16);

        if (!function_exists('mcrypt_encrypt'))
            throw new Exception('Mcrypt extension is not installed for PHP.');
        $aes = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $saltedHash, $data, MCRYPT_MODE_CBC, str_repeat("\0", 16));
        return json_decode(trim($aes, "\0\4"));
    }
}