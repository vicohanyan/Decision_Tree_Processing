<?php

namespace src\DecisionThree\Actions;

use src\MessageSenders\SmsSender;

class SmsAction extends AbstractAction
{
    public string $phone;
    public string $message;

    public function __construct(object $data)
    {
        parent::__construct($data);
        $this->phone = $data->phone;
        $this->message = $data->message;
    }

    /**
     * @return void
     */
    public function execute(): void
    {
        SmsSender::sendMessage($this->phone, $this->message);
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return array_merge(parent::jsonSerialize(), [
            'phone' => $this->phone,
            'message' => $this->message,
        ]);
    }
}