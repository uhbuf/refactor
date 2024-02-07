<?php

namespace NW\WebService\References\Operations\Notification;

class TsReturnOperation extends AbstractReferencesOperation
{
    /** @var SendEmailService  */
    private SendEmailService $sendEmailService;

    public function __construct()
    {
        $this->sendEmailService = new SendEmailService();
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function doOperation(): array
    {
        $sendEmailRequest = new SendEmailRequest();
        $validateRequest = $sendEmailRequest->validated((array) $this->getRequest('data'));
        $sendMailDTO = SendEmailDTO::createDTO($validateRequest);
        $result = $this->sendEmailService->sendEmail($sendMailDTO);
        return SendEmailResponse::make($result);
    }
}
