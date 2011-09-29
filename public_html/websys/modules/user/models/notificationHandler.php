<?php

fileLoader::load('user/models/notificationEvents');
fileLoader::load('service/mailer/mailer');
class notificationHandler
{
    public function __construct()
    {
    }

    public function factory()
    {
        return new self(notificationEventRegistry::getEvents());
    }

    public function handle(notificationEvent $event, $title, $body)
    {
        $users = $this->searchEligibleUsersForNotification($event);
        foreach ($users as $user) {
            $this->sendMail($user['name'], $user['email'], $title, $body);
            //var_dump($user['name'], $user['email'], $title, $body);
        }
    }

    private function searchEligibleUsersForNotification(notificationEvent $event)
    {
        $users = array();
        $notificationConfigMapper = systemToolkit::getInstance()->getMapper('user', 'notificationConfig');

        $notificatedUsers = $notificationConfigMapper->searchByEvent($event);
        foreach ($notificatedUsers as $notificatedUser) {
            $users[] = array(
                'email' => $notificatedUser->getUser()->getEmail(),
                'name' => $notificatedUser->getUser()->getLogin(),
                );
        }
        return $users;
    }

    private function sendMail($name, $email, $title, $body)
    {
        $mailer = mailer::factory();
        $mailer->set(
            $email,
            $name,
            systemConfig::$mailer['default']['params']['smtp_user'],
            systemConfig::$mailer['default']['params']['default_topic'],
            systemConfig::$appName . " v" . systemConfig::$appVersion . ' ' . $title,
            $body
        );
        $mailer->send();
    }
}