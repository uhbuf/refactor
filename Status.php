<?php

namespace NW\WebService\References\Operations\Notification;

class Status
{
    public const COMPLETED = 'COMPLETED';
    public const PENDING = 'PENDING';
    public const REJECT = 'REJECT';

    private int $id;
    private string $name;

    /**
     * @var array
     */
    public static array $statuses = [
        self::COMPLETED,
        self::PENDING,
        self::REJECT,
    ];

    /**
     * @param int $id
     *
     * @return string
     */
    public static function getName(int $id): string
    {
        $a = [
            0 => 'Completed',
            1 => 'Pending',
            2 => 'Rejected',
        ];

        return $a[$id];
    }
}