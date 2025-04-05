<?php

namespace src\DecisionThree\Parser;

use src\DecisionThree\Actions\ActionInterface;
use src\DecisionThree\Actions\LoopAction;
use src\Exceptions\NotFoundActionException;

class DecisionThreeParserWithSubTree extends DecisionThreeParserAbstract
{

    /**
     * @param string $classname
     * @param object $data
     * @return ActionInterface
     * @throws NotFoundActionException
     */
    public function makeObject(string $classname, object $data): ActionInterface
    {
        $action = parent::makeObject($classname, $data);
        if (isset($data->subtree)) {

            /**
             * @var LoopAction $action
             */
            $action->setSubtree($this->createObjectWithSubtree($data->subtree));
        }
        return $action;
    }

    /**
     * @param array $data
     * @return array
     * @throws NotFoundActionException
     */
    private function createObjectWithSubtree(array $data): array
    {
        return array_map(fn($subItem) => $this->makeObject($subItem->type, $subItem), (array) $data);
    }
}