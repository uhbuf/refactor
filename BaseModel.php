<?php

namespace NW\WebService\References\Operations\Notification;

class BaseModel
{
    /**
     * @param int $id
     *
     * @return $this
     */
    public static function findOrFail(int $id): static
    {
        if (! self::isExist($id)) {
            \Exception(get_called_class() . ' not found', 404);
        }
        return new static;
    }

    /**
     * @param int $id
     *
     * @return bool
     */
    private static function isExist(int $id): bool
    {
        return true;
    }
}