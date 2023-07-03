<?php

namespace OscarTeam\Experian\Classes;

class Response
{
    public function __construct(public $response)
    {
    }

    public function toArray(): array
    {
        return (array)$this->response;
    }
}