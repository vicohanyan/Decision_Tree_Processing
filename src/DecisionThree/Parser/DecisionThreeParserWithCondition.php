<?php

namespace src\DecisionThree\Parser;

use src\DecisionThree\Actions\ActionInterface;
use src\DecisionThree\Actions\ConditionAction;
use src\Exceptions\NotFoundActionException;
use src\Exceptions\NotFoundTrueActionInConditionException;

class DecisionThreeParserWithCondition extends DecisionThreeParserAbstract
{

    /**
     * @param string $classname
     * @param object $data
     * @return ActionInterface
     * @throws NotFoundActionException
     * @throws NotFoundTrueActionInConditionException
     */
    public function makeObject(string $classname, object $data): ActionInterface
    {
        if (!isset($data->trueAction)) {
            throw new NotFoundTrueActionInConditionException('The Condition action must have a "true" action.', 404);
        }

        /**
         * @var ConditionAction $action
         */
        $action = parent::makeObject($classname, $data);
        return $action;
    }

}