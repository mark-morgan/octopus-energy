# Octopus Energy PHP SDK
These PHP bindings provide convenient access to the Octopus Energy Restful API for PHP applications.

## Requirements
* An Octopus Energy account API Key (https://octopus.energy/dashboard/developer/)
* PHP >= 7.1

## Installation
Install using composer
```bash
composer require markmorgan/octopus-energy
```

## Usage
### Initialisation
Before requesting data you will need to set your access credentials. This is done by initialising the LivnClient:
```php
$apiKey = 'my-octopus-apiky';

$client = new \OctopusENergy\Client([
    'apiKey' => $apiKey
]);
```
