# Octopus Energy PHP SDK
These PHP bindings provide convenient access to the Octopus Energy Restful API for PHP applications.

`Note: Accounts and Quotes endpoints are not implemented in this SDK as they are only available to Partner Organisations.`

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
Before requesting data you will need to set your access credentials. This is done by initialising the OctopusEnergy Client:
```php
$apiKey = 'my-octopus-apikey';

$client = new \OctopusEnergy\Client($apiKey);
```

### Services
The SDK has services for `Product`, `Meter`, and `Industry` functions. The best place to look for all the functions available is within the services themselves. 

#### Product
Fetch all products (additional product filters available, see function signature):
```php
$productsSearch = $client->products->all();
```

Fetch a specific product from its product code:
```php
$productCode = 'VAR-21-09-29';
$product = $client->products->get($productCode);
```

#### Meter
Fetch info for a specific meter:
```php
$mpan = 'YOUR MPAN NUMBER';
$meter = $client->meters->getElectricityMeter($mpan);
```

Fetch meter consumption:
```php
$mpan = 'YOUR MPAN NUMBER';
$serialNumber = 'YOUR METER SERIAL NUMBER';

$consumptionSearch = $client->meters->getElectricityMeterConsumption(
    $mpan,
    $serialNumber
);
```

Filter the consumption between specific dates:
```php
$fromDate = new \DateTime();
$fromDate->setTimestamp(1640995201);    // Jan 1st 2022

$toDate = new \DateTime();
$toDate->setTimestamp(1643673601);      // Feb 1st 2022

$pageNumber = 1;
$consumptionSearch = $client->meters->getElectricityMeterConsumption(
    $mpan,
    $serialNumber,
    $pageNumber,
    $fromDate,
    $toDate
);
```

#### Industry
Fetch information about Grid Supply Points:
```php
// fetch all grid supply point info
$gspSearch = $client->industry->getGridSupplyPoints();

// fetch grid supply point info for a postcode
$postcode = 'cf104uw';
$gspSearch = $client->industry->getGridSupplyPoints($postcode);
```
