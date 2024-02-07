<?php

namespace NW\WebService\References\Operations\Notification;

class SendEmailRequest
{
    /**
     * @param array $request
     *
     * @return array
     * @throws \Exception
     */
    public function validated(array $request): array
    {
        $this->isRequired($request);
        return $request;
    }

    /**
     * @param string $value
     *
     * @return void
     * @throws \Exception
     */
    private function callException(string $value): void
    {
        throw new \Exception("Empty {$value}", 422);
    }

    /**
     * @param array $request
     *
     * @return void
     * @throws \Exception
     */
    private function isRequired(array $request): void
    {
        $request['resellerId'] ?: $this->callException('resellerId');
        $request['notificationType'] ?: $this->callException('notificationType');
        $request['complaintId'] ?: $this->callException('complaintId');
        $request['complaintNumber'] ?: $this->callException('complaintNumber');
        $request['creatorId'] ?: $this->callException('creatorId');
        $request['expertId'] ?: $this->callException('expertId');
        $request['clientId'] ?: $this->callException('clientId');
        $request['consumptionId'] ?: $this->callException('consumptionId');
        $request['consumptionNumber'] ?: $this->callException('consumptionNumber');
        $request['agreementNumber'] ?: $this->callException('agreementNumber');
        $request['date'] ?: $this->callException('date');
    }
}