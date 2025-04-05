<?php

namespace src\DecisionThree\Parser;

use src\Exceptions\CannotSerializeToJsonException;


final class DecisionTreeJsonEncoder
{
    /**
     * @throws CannotSerializeToJsonException
     */
    public static function encode(array $services): string
    {
        $data = [
            'decisionTree' => $services
        ];
        try{
            return  json_encode($data, JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        }catch (\Throwable $e){
            throw new CannotSerializeToJsonException("Cannot serialize to json",422,$e);
        }
    }
}