<?php

namespace NW\WebService\References\Operations\Notification;

interface MessageInterface
{
    /**
     * @param array $messageInfo
     * @param SendEmailDTO $sendMailDTO
     * @param string $event
     *
     * @return void
     */
    public function sendMessage(array $messageInfo, SendEmailDTO $sendMailDTO, string $event):  void;
}