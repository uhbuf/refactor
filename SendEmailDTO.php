<?php

namespace NW\WebService\References\Operations\Notification;

class SendEmailDTO
{
    public readonly int $resellerId;
    public readonly int $notificationType;
    public readonly int $clientId;
    public readonly int $creatorId;
    public readonly int $expertId;
    public readonly array $differences;
    public readonly int $complaintId;
    public readonly string $complaintNumber;
    public readonly int $consumptionId;
    public readonly string $consumptionNumber;
    public readonly string $agreementNumber;
    public readonly string $date;

    /**
     * @param array $data
     *
     * @return self
     */
    public static function createDTO(array $data): self
    {
        $dto = new self();
        $dto->resellerId = $data['resellerId'];
        $dto->notificationType = $data['notificationType'];
        $dto->clientId = $data['clientId'];
        $dto->creatorId = $data['creatorId'];
        $dto->expertId = $data['expertId'];
        $dto->differences = $data['differences'];
        $dto->complaintId = $data['complaintId'];
        $dto->complaintNumber = $data['complaintNumber'];
        $dto->consumptionId = $data['consumptionId'];
        $dto->consumptionNumber = $data['consumptionNumber'];
        $dto->agreementNumber = $data['agreementNumber'];
        $dto->date = $data['date'];
        return $dto;
    }
}