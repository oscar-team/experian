# Experian API Library

### Perform credit checks on Experian for company and individual.

This is a PHP Library created to communicate with Experian System for credit checks of company and individuals.

## Installation:

Use `composer` package manager and run 

```composer require oscar-team/experian```

## Usage:

```php
<?php 
$experianConnector  = new Experian();

// this will create connection with Firma WSDL
$wsdlOptions = [
    // options
    'location' => '',
    'soap_version' => '',
    'proxy_host' => ''
    ....
];
$data = [
    'navn' => '',
    ...,
];
$experianConnector->firmRegistrationByName($data, $wsdlOptions);
$experianConnector->firmRegistrationByCVR($data, $wsdlOptions);

//Custom method and custom function
$data = [
    ...
];
$experianConnector->customRequest('AKSOpen', 'TilmeldFirmaCVR', $data);

// List all possible function names of a SOAP Method
$experianConnector->client->getMethodNames();
```

## Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

Please make sure to update tests as appropriate.