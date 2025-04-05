<?php

namespace src\Services;

use src\DecisionThree\Actions\ActionInterface;
use src\DecisionThree\Parser\DecisionTreeJsonDecoder;
use src\DecisionThree\Parser\DecisionTreeJsonEncoder;
use src\Exceptions\CannotSerializeToJsonException;

class DecisionExecuteFacadeService
{
    private DecisionTreeJsonDecoder $parser;
    /**
     * @var []ActionInterface $actions
     */
    private array $actions = [];

    public function __construct()
    {
        $this->parser = new DecisionTreeJsonDecoder();
    }

    /**
     * @return void
     */
    public function run(): void
    {
        foreach ($this->actions as $action) {
            /**
             * @var ActionInterface $action
             */
            $action->execute();
        }
    }

    public function deserialize(string $jsonString): void
    {
        $json = json_decode($jsonString);
        $this->actions = $this->parser->parse($json->decisionTree);
    }

    /**
     * @throws CannotSerializeToJsonException
     */
    public function serialize(): string
    {
        return DecisionTreeJsonEncoder::encode($this->actions);
    }
}