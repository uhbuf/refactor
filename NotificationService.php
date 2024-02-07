<?php

namespace NW\WebService\References\Operations\Notification;

class NotificationService
{
    /**
     * @var string|null
     */
    public ?string $error;

    /**
     * @param int $resellerId
     * @param int $clientId
     * @param string $eventName
     * @param string $changes
     * @param array $template
     *
     * @return void
     */
    public function sendNotification(int $resellerId, int $clientId, string $eventName, string $changes, array $template): void
    {
        if(true){
            $this->error = 'Error Notification';
        }
    }
}