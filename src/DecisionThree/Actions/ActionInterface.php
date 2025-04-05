<?php

namespace src\DecisionThree\Actions;

interface ActionInterface
{
    /**
     * Execute Action
     * @return void
     */
    public function execute():void;

    /**
     *
     * @return mixed
     */
    public function jsonSerialize(): mixed;

}