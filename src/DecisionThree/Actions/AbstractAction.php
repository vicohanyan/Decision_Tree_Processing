<?php

namespace src\DecisionThree\Actions;

use src\DecisionThree\Actions\ActionInterface;

abstract class AbstractAction implements ActionInterface
{
    public string $type;

    public function __construct($data)
    {
        $this->type = $data->type;
    }

    /**
     * @return string[]
     */
    public function jsonSerialize(): array
    {
        return [
            'type' => $this->type,
        ];
    }

}