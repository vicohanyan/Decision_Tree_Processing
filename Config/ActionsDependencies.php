<?php

use src\DecisionThree\Actions\ConditionAction;
use src\DecisionThree\Actions\EmailAction;
use src\DecisionThree\Actions\LoopAction;
use src\DecisionThree\Actions\SmsAction;

return [
    "email" => EmailAction::class,
    "sms" => SmsAction::class,
    "loop" => LoopAction::class,
    "condition" => ConditionAction::class,
];