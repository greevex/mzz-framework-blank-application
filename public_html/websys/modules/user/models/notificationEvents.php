<?php

interface notificationEvent
{
    function getName();
    function getLabel();
}

class notificationEventRegistry
{
    public static function getEvents()
    {
        return array(
            new siteRespondTimeoutEvent,
            new remainsChangedEvent
        );
    }

    public static function searchByName($name)
    {
        foreach (self::getEvents() as $event) {
            if ($event->getName() == $name) {
                return $event;
            }
        }
    }
}

class remainsChangedEvent implements notificationEvent
{
    public function getName()
    {
        return 'remains_changed';
    }

    public function getLabel()
    {
        return 'Неожиданное изменение остатков';
    }
}

class siteRespondTimeoutEvent implements notificationEvent
{
    public function getName()
    {
        return 'respond_timeout';
    }

    public function getLabel()
    {
        return 'Долгое соединение с сайтом';
    }
}