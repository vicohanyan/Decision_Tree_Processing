<?php

namespace src\MessageSenders;

class SmsSender extends MessageSenderAbstract
{
    public static function sendMessage(string $to, string $body): bool
    {
        self::logMessage("An sms was sent to '{$to}' with the text '{$body}'");
        return true;
    }
}