<?php

namespace NW\WebService\References\Operations\Notification;

class SendEmailResponse
{
    /**
     * @param array $response
     *
     * @return array
     */
    public static function make(array $response): array
    {
        return [
            'notificationEmployeeByEmail' => $response['notificationEmployeeByEmail'],
            'notificationClientByEmail' => $response['notificationClientByEmail'],
            'notificationClientBySms' => [
                'isSent' => $response['notificationClientBySms']['isSent'] ?? false,
                'message' => $response['notificationClientBySms']['message'] ?? null,
            ],
        ];
    }
}