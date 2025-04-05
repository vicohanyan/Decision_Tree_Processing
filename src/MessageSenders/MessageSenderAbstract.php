<?php

namespace src\MessageSenders;

abstract class MessageSenderAbstract
{

    /**
     * @param string $data
     * @return void
     */
    protected static function logMessage(string $data): void
    {
        echo $data . PHP_EOL;
        echo "<hr>";
    }
}