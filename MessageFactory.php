<?php

namespace NW\WebService\References\Operations\Notification;

class MessageFactory
{
    public const RESELLER = 'reseller';
    public const CLIENT = 'client';

    /**
     * @var array|string[]
     */
    public static array $types = [
        self::RESELLER => ResellerMessageService::class,
        self::CLIENT => ClientMessageService::class
    ];

    /**
     * @param string $type
     *
     * @return MessageInterface
     */
    public static function create(string $type): MessageInterface
    {
        return new self::$types[$type];
    }
}