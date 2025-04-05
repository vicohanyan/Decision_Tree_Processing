<?php

namespace src\MessageSenders;


class EmailSender extends MessageSenderAbstract
{

    /**
     *  @ToDO Get this from Config
     */
    public static string $from = 'no-reply@messagesender.com';

    public static function sendMessage(string $to,string $subject,string $body): bool
    {
        self::logMessage("An email was sent from '". self::$from ."' to '{$to}' with the subject '{$subject}' and the body '{$body}'");
        return true;
    }
}