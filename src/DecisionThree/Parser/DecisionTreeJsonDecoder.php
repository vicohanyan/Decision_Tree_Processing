<?php

namespace src\DecisionThree\Parser;

use src\DecisionThree\Actions\ActionInterface;
use src\DecisionThree\Actions\ConditionAction;
use src\DecisionThree\Actions\LoopAction;


final class DecisionTreeJsonDecoder
{
    private DecisionThreeParser $baseParser;
    private DecisionThreeParserWithSubTree $parserWithSubTree;
    private DecisionThreeParserWithCondition $parserCondition;

    public function __construct()
    {
        $this->baseParser = new DecisionThreeParser();
    }

    /**
     * @param object $data
     * @return DecisionThreeParserInterface
     */
    public function parserChecker(object $data): DecisionThreeParserInterface
    {
        if (isset($data->trueAction)) {
            if (!isset($this->parserCondition)) {
                $this->parserCondition = new DecisionThreeParserWithCondition();
            }
            return $this->parserCondition;
        }
        if (isset($data->subtree)) {
            if (!isset($this->parserWithSubTree)) {
                $this->parserWithSubTree = new DecisionThreeParserWithSubTree();
            }
            return $this->parserWithSubTree;
        }
        return $this->baseParser;
    }


    /**
     * @param array $data
     * @return array
     */
    public function parse(array $data): array
    {
        $actions = [];
        foreach ($data as $item) {
            if (is_object($item)) {
                $actions[] = $this->parseItem($item);
            }
        }
        return $actions;
    }

    /**
     * @param \stdClass $item
     * @return ActionInterface
     */
    private function parseItem(\stdClass $item): ActionInterface
    {
        $parser = $this->parserChecker($item);
        $action = $parser->makeObject($item->type, $item);
        if ($action instanceof ConditionAction) {
            if (is_object($item->trueAction)) {
                $action->setTrueAction($this->parseItem($item->trueAction));
            }
            if (isset($item->falseAction) && is_object($item->falseAction)) {
                $action->setFalseAction($this->parseItem($item->falseAction));
            }
        } elseif ($action instanceof LoopAction && isset($item->subtree) && is_array($item->subtree)) {
            $subtreeActions = [];
            foreach ($item->subtree as $subItem) {
                if (is_object($subItem)) {
                    $subtreeActions[] = $this->parseItem($subItem);
                }
            }
            $action->setSubtree($subtreeActions);
        }
        return $action;
    }
}