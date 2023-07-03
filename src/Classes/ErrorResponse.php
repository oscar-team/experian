<?php

namespace OscarTeam\Experian\Classes;

class ErrorResponse extends Response
{
    public function __construct(public $response)
    {
        $this->response = $response->Error;
    }
}
