<?php

namespace src\DecisionThree\Parser;

use src\DecisionThree\Actions\ActionInterface;
use src\Exceptions\ConfigurationLoadErrorException;
use src\Exceptions\NotFoundActionException;

abstract class DecisionThreeParserAbstract implements DecisionThreeParserInterface
{
    protected array $actionTypes;
    protected const array EXCLUDED_ATTRIBUTES = ["subtree", "type","trueAction","falseAction"];

    /**
     * @throws ConfigurationLoadErrorException
     */
    public function __construct()
    {
        try {
            $this->actionTypes = require 'Config/ActionsDependencies.php';
        } catch (\Throwable $e) {
            throw new ConfigurationLoadErrorException(previous: $e);
        }
    }

    /**
     * @param string $classname
     * @param object $data
     * @return ActionInterface
     * @throws NotFoundActionException
     */
    public function makeObject(string $classname, object $data): ActionInterface
    {
        if (!array_key_exists($data->type, $this->actionTypes)) {
            throw new NotFoundActionException("Action '{$data->type}' not found in registered types", 404);
        }
        if (!isset($this->actionTypes[$classname]) || !class_exists($this->actionTypes[$classname])) {
            throw new NotFoundActionException("Failed to resolve action: class '{$classname}' does not exist or is not registered.");
        }
        $action = new $this->actionTypes[$classname]($data);
        $this->fillActionObject($action, $data);
        return $action;
    }

    /**
     * @param ActionInterface $action
     * @param object $data
     * @return void
     */
    protected function fillActionObject(ActionInterface $action, object $data): void
    {
        foreach ($data as $key => $value) {
            if (in_array($key, self::EXCLUDED_ATTRIBUTES, true)) {
                continue;
            }
            if (property_exists($action, $key)) {
                $action->{$key} = $value;
            }
        }
    }
}