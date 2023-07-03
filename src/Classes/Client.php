<?php

namespace OscarTeam\Experian\Classes;

use SoapClient;
use SoapHeader;

class Client
{
    private SoapClient $instance;

    public function __construct(private string $wsdl, private array $options = [])
    {
        $this->instance = new SoapClient($this->wsdl, $this->options);
    }

    public function request(string $methodName, array $params, ?array $options = null,
        SoapHeader|array|null $inputHeaders = null, array $outputHeaders = null): Response
    {
        try {
            $response = $this->instance->__soapCall($methodName, $params, $options, $inputHeaders,$outputHeaders);
            return $this->parseResult($methodName, $response);
        } catch (\SoapFault $e) {
            return $e;
        }
    }

    public function getMethodNames(): ?array
    {
        return $this->instance->__getFunctions();
    }
    private function parseResult(string $methodName, $response): Response
    {
        $methodAwareResponse = $response->{$methodName . 'Result'};
        $response = new Response($methodAwareResponse);

        if (property_exists($methodAwareResponse, 'Error')) {
            $response = new ErrorResponse($methodAwareResponse);
        }
        return $response;
    }

    public function getWSDLUrl(): string
    {
        return $this->wsdl;
    }
}
