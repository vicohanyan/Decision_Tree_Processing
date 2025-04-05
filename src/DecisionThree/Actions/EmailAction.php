<?php

namespace src\DecisionThree\Actions;

use src\MessageSenders\EmailSender;

class EmailAction extends AbstractAction
{
    public string $to;
    public string $subject;
    public string $message;

    public function __construct(object $data)
    {
        parent::__construct($data);
        $this->to = $data->to;
        $this->subject = $data->subject;
        $this->message = $data->message;
    }

    /**
     * @return void
     */
    public function execute(): void
    {
        EmailSender::sendMessage($this->to, $this->subject, $this->message);
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return array_merge(parent::jsonSerialize(), [
            'to' => $this->to,
            'subject' => $this->subject,
            'message' => $this->message,
        ]);
    }
}