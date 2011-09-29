<?php

class flash
{
    const NAME = "_flash_message";
    private $session;
    public function __construct()
    {
        $this->session = systemToolkit::getInstance()->getSession();
    }

    public function get()
    {
        $val = $this->session->get(self::NAME);
        $this->session->destroy(self::NAME);
        return $val;
    }

    public function set($value)
    {
        $this->session->set(self::NAME, $value);
    }

    public static function getInstance()
    {
        return new self();
    }

    public function notEmpty()
    {
        return $this->session->exists(self::NAME);
    }
}