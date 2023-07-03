<?php

namespace OscarTeam\Experian;

use OscarTeam\Experian\Classes\Client;
use OscarTeam\Experian\Classes\ErrorResponse;
use OscarTeam\Experian\Classes\Response;
use ReflectionClass;

class Experian
{
    protected Client $client;
    public function __construct(protected ?string $environment = null)
    {
        $this->environment = $environment ?? $this->environment;
    }

    private function getBaseUrl(): string
    {
        if ($this->environment !== 'prod') {
            return "https://uat.ws2.rki.dk";
        }
        return "https://ws2.rki.dk";
    }

    private function initiateClientFor(string $method, ?array $options = []): Experian
    {
        $method = ucfirst($method);
        $generatedWSDL = $this->getBaseUrl() . "/{$method}.asmx?WSDL";

        if (!isset($this->client) || $this->client->getWSDLUrl() !== $generatedWSDL) {
            $this->client = new Client($generatedWSDL, $options);
        }

        return $this;
    }

    public function personRegistrationByName(array $personData, ?array $options = []): Response
    {
        $this->initiateClientFor('person', $options);
        return $this->client->request('SoegPersonRegistreringNavn', $personData);
    }

    public function firmRegistrationByName(array $firmData, ?array $options = []): Response
    {
        $this->initiateClientFor('firma', $options);
        return $this->client->request('SoegFirmaRegistreringNavn', $firmData);
    }

    public function firmRegistrationByCVR(array $firmData, ?array $options = []): Response
    {
        $this->initiateClientFor('firma', $options);
        return $this->client->request('SoegFirmaRegistreringCvr', $firmData);
    }

    public function customRequest(string $asmxMethodName, string $methodName, array $data,
        ?array $asmxOptions = [], ?array $options = null, SoapHeader|array|null $inputHeaders = null,
        array $outputHeaders = null): Response
    {
        return $this->initiateClientFor($asmxMethodName, $asmxOptions)
            ->client->request($methodName, $data, $options, $inputHeaders,$outputHeaders);
    }
}
