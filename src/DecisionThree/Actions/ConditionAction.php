<?php

namespace src\DecisionThree\Actions;

class ConditionAction extends AbstractAction
{

    public string $expression;
    public ?ActionInterface $trueAction;
    public ?ActionInterface $falseAction;

    public function __construct(object $data)
    {
        parent::__construct($data);
        $this->expression = $data->expression;
    }

    /**
     * @param ActionInterface $trueAction
     * @return void
     */
    public function setTrueAction(ActionInterface $trueAction): void{
        $this->trueAction = $trueAction;
    }

    /**
     * @param ActionInterface $falseAction
     * @return void
     */
    public function setFalseAction(ActionInterface $falseAction): void{
        $this->falseAction = $falseAction;
    }

    /**
     * @return void
     */
    public function execute(): void
    {
        $result = false;
        try {
            /**
             * @ToDo Change eval to something better and secure
             */
            $result = eval("return {$this->expression};");
        } catch (\Throwable $e) {
            echo "Error evaluating condition: " . $e->getMessage() . PHP_EOL;
        }
        if ($result) {
            $this->trueAction->execute();
        } elseif (isset($this->falseAction)) {
            $this->falseAction->execute();
        }
    }


    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return array_merge(parent::jsonSerialize(), [
            'expression' => $this->expression,
            'trueAction' => $this->trueAction,
            'falseAction' => $this->falseAction,
        ]);
    }
}