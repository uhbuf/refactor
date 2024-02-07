<?php

namespace NW\WebService\References\Operations\Notification;
class Seller extends Contractor
{
    function getResellerEmailFrom(): string
    {
        return 'contractor@example.com';
    }

    /**
     * @param $event
     *
     * @return string[]
     */
    function getEmailsByPermit($event): array
    {
        // fakes the method
        return ['someemeil@example.com', 'someemeil2@example.com'];
    }
}