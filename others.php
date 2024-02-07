<?php

namespace NW\WebService\References\Operations\Notification;

/**
 * Class Contractor
 */
class Contractor extends BaseModel
{
    const TYPE_CUSTOMER = 0;

    /** @var int  */
    private int $id;

    /** @var int  */
    private int $type;

    /** @var string  */
    private string $name;

    /** @var bool  */
    private bool $is_mobile;

    /**
     * @return bool
     */
    public function isMobile(): bool
    {
        return $this->is_mobile;
    }

    /**
     * @param bool $is_mobile
     */
    public function setIsMobile(bool $is_mobile): void
    {
        $this->is_mobile = $is_mobile;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return int
     */
    public function getType(): int
    {
        return $this->type;
    }

    /**
     * @param int $type
     */
    public function setType(int $type): void
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getFullName(): string
    {
        return $this->getName() . ' ' . $this->getId();
    }
}