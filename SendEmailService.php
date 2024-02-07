<?php

namespace NW\WebService\References\Operations\Notification;

use http\Client;

class SendEmailService
{
    public const TYPE_NEW = 1;
    public const TYPE_CHANGE = 2;

    /**
     * @param SendEmailDTO $sendMailDTO
     *
     * @return array
     * @throws \Exception
     */
    public function sendEmail(SendEmailDTO $sendMailDTO): array
    {
        $client = Contractor::findOrFail($sendMailDTO->clientId);
        if ($client->getType() !== Contractor::TYPE_CUSTOMER) {
            throw new \Exception('сlient not found!', 404);
        }

        $cr = Seller::findOrFail($sendMailDTO->creatorId);

        $et = Employee::findOrFail($sendMailDTO->expertId);

        $differences = $this->getDifference($sendMailDTO);
        $result = [
            'notificationEmployeeByEmail' => false,
            'notificationClientByEmail' => false,
            'notificationClientBySms' => [
                'isSent' => false,
                'message' => '',
            ],
        ];
        $templateData = [
            'COMPLAINT_ID' => $sendMailDTO->complaintId,
            'COMPLAINT_NUMBER' => $sendMailDTO->complaintNumber,
            'CREATOR_ID' => $sendMailDTO->creatorId,
            'CREATOR_NAME' => $cr->getFullName(),
            'EXPERT_ID' => $sendMailDTO->expertId,
            'EXPERT_NAME' => $et->getFullName(),
            'CLIENT_ID' => $sendMailDTO->clientId,
            'CLIENT_NAME' => $client->getFullName(),
            'CONSUMPTION_ID' => $sendMailDTO->consumptionId,
            'CONSUMPTION_NUMBER' => $sendMailDTO->consumptionNumber,
            'AGREEMENT_NUMBER' => $sendMailDTO->agreementNumber,
            'DATE' => $sendMailDTO->date,
            'DIFFERENCES' => $differences,
        ];

        $emailFrom = $cr->getResellerEmailFrom();
        // Получаем email сотрудников из настроек
        $emails = $cr->getEmailsByPermit('tsGoodsReturn');
        if (! empty($emailFrom) && count($emails) > 0) {
            $resellerMessageService = $this->initMessageService(MessageFactory::RESELLER);
            foreach ($emails as $email) {
                $resellerMessageService->sendMessage([
                    [
                        'emailFrom' => $emailFrom,
                        'emailTo' => $email,
                        'subject' => __('complaintEmployeeEmailSubject', $templateData, $sendMailDTO->resellerId),
                        'message' => __('complaintEmployeeEmailBody', $templateData, $sendMailDTO->resellerId),
                    ],
                ], $sendMailDTO, NotificationEvents::ChangeReturnStatus->name);
                $result['notificationEmployeeByEmail'] = true;
            }
        }
        if ($this->isStatusChanged($sendMailDTO->notificationType, $sendMailDTO->differences['to'])) {
            if (! empty($emailFrom) && ! empty($client->email)) {
                $clientMessageService = $this->initMessageService(MessageFactory::CLIENT);
                $clientMessageService->sendMessage([
                    0 => [
                        'emailFrom' => $emailFrom,
                        'emailTo' => $client->email,
                        'subject' => __('complaintClientEmailSubject', $templateData, $sendMailDTO->resellerId),
                        'message' => __('complaintClientEmailBody', $templateData, $sendMailDTO->resellerId),
                    ],
                ],
                    $sendMailDTO,
                    NotificationEvents::ChangeReturnStatus->name);
                $result['notificationClientByEmail'] = true;
            }

            if ($client->isMobile()) {
                $notificationInfo = $this->sendNotification($sendMailDTO, $client, $templateData);
                $result['notificationClientBySms']['isSent'] = $notificationInfo ?? true;
            }
        }

        return $result;
    }

    /**
     * @param int $notificationType
     * @param string $differenceTo
     *
     * @return bool
     */
    private function isStatusChanged(int $notificationType, string $differenceTo): bool
    {
        return ($notificationType === self::TYPE_CHANGE && $differenceTo);
    }

    /**
     * @param string $type
     *
     * @return MessageInterface
     */
    private function initMessageService(string $type): MessageInterface
    {
        return MessageFactory::create($type);
    }

    /**
     * @param SendEmailDTO $sendMailDTO
     *
     * @return string
     */
    private function getDifference(SendEmailDTO $sendMailDTO): string
    {
        $differences = '';
        if ($sendMailDTO->notificationType === self::TYPE_NEW) {
            $differences = __('NewPositionAdded', null, $sendMailDTO->resellerId);
        } elseif ($sendMailDTO->notificationType === self::TYPE_CHANGE && $sendMailDTO->differences) {
            $differences = __('PositionStatusHasChanged', [
                'FROM' => Status::getName($sendMailDTO->differences['from']),
                'TO' => Status::getName($sendMailDTO->differences['to']),
            ], $sendMailDTO->resellerId);
        }
        return $differences;
    }

    /**
     * @param SendEmailDTO $sendMailDTO
     * @param Contractor $client
     * @param array $templateData
     *
     * @return string|null
     */
    private function sendNotification(SendEmailDTO $sendMailDTO, Contractor $client, array $templateData): ?string
    {
        $notificationService = new NotificationService();
        $notificationService->sendNotification(
            $sendMailDTO->resellerId,
            $client->getId(),
            NotificationEvents::ChangeReturnStatus->name,
            $sendMailDTO->differences['to'],
            $templateData,
        );
        return $notificationService->error
            ? $notificationService->error
            : '';
    }
}
