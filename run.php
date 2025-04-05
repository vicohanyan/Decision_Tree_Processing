<?php

// open for debug
//ini_set('display_errors', '1');
//ini_set('display_startup_errors', '1');
//error_reporting(E_ALL);


require_once __DIR__ . '/autoloader.php';

use src\Exceptions\CannotSerializeToJsonException;
use src\Services\DecisionExecuteFacadeService;

// Test json data
$data = <<<JSON
{
  "decisionTree": [
    {
      "type": "email",
      "to": "user@example.com",
      "subject": "Hello!",
      "message": "This is your first email."
    },
    {
      "type": "sms",
      "phone": "+1000000000",
      "message": "You've got an email!"
    },
    {
      "type": "email",
      "to": "user@example.com",
      "subject": "Follow-up",
      "message": "This is your second email."
    },
    {
      "type": "condition",
      "expression": "date('Y-m-d') === '2025-01-01'",
      "trueAction": {
        "type": "sms",
        "phone": "+123456789",
        "message" : "sms message"
      },
      "falseAction": {
        "type": "email",
        "to": "user@example.com",
        "subject": "email subject",
        "message" : "email body"
      }
    },
    {
      "type": "loop",
      "iterationsCount": 4,
      "subtree": [
        {
          "type": "condition",
          "expression": "rand(0, 1) === 1",
          "trueAction": {
            "type": "sms",
            "phone": "+1000000000",
            "message" : "sms message"
          }
        },
        {
          "type": "condition",
          "expression": "rand(0, 1) === 1",
          "trueAction": {
            "type": "sms",
            "phone": "+1000000001",
            "message" : "sms message"
          }
        },
        {
          "type": "condition",
          "expression": "rand(0, 1) === 1",
          "trueAction": {
            "type": "sms",
            "phone": "+1000000002",
            "message" : "sms message"
          }
        },
        {
          "type": "condition",
          "expression": "rand(0, 1) === 1",
          "trueAction": {
            "type": "sms",
            "phone": "+1000000003",
            "message" : "sms message"
          }
        }
      ]
    }
  ]
}
JSON;


$decisionService = new  DecisionExecuteFacadeService();

$decisionService->deserialize($data);
$decisionService->run();
echo "<br>";
try {
    echo $decisionService->serialize();
} catch (CannotSerializeToJsonException $e) {
    echo "something went wrong cannot serialize to json";
}
