<?php

namespace src\DecisionThree\Parser;

use src\DecisionThree\Actions\ActionInterface;

interface DecisionThreeParserInterface
{
    /**
     * @param string $classname
     * @param object $data
     * @return ActionInterface
     */
    public function makeObject(string $classname, object $data): ActionInterface;
}