<?php

namespace src\DecisionThree\Actions;

class LoopAction extends AbstractAction
{

    public int $iterationsCount;

    /**
     * @var ActionInterface[]
     */
    public array $subtree;

    public function __construct(object $data)
    {
        parent::__construct($data);
        $this->iterationsCount = $data->iterationsCount;
        $this->subtree = $data->subtree;
    }

    /**
     * @return void
     */
    public function execute(): void
    {
        for($i = 0; $i < $this->iterationsCount; $i++) {
            /** @var ActionInterface $action */
            $action = $this->subtree[$i] ?? null;
            if ($action instanceof ActionInterface) {
                /**
                 * @ToDo In future, add execution into queue
                 */
                $action->execute();
            }
        }
    }

    /**
     * @param array $subtree
     * @return void
     */
    public function setSubtree(array $subtree): void{
        $this->subtree = $subtree;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return array_merge(parent::jsonSerialize(), [
            'iterationsCount' => $this->iterationsCount,
            'subtree' => $this->subtree,
        ]);
    }
}