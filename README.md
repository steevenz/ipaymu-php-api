<img width="100" src="https://my.ipaymu.com/asset/images/logo-ipaymu.png">

The Official iPaymu-php-api
==============

This is the Official PHP wrapper/library for iPaymu Payment API, that is compatible with Composer. Visit [https://ipaymu.com](https://ipaymu.com) for more information about the product and see documentation at [https://ipaymu.com/en/api-documentation/](https://ipaymu.com/en/api-documentation/) for more technical details.

Free signup here [https://my.ipaymu.com/members/signup.htm](https://my.ipaymu.com/members/signup.htm) to accept payment online now!

## Installation
The best way to use this package is using [composer](https://getcomposer.org/)
```
composer require ipaymu/ipaymu-php-api
```

## Usage

### Requirement

First, get your apikey & va number from iPaymu dashboard.

### Initialization
```php
<?php
use iPaymu\iPaymu;

$apiKey = 'your-apikey';
$va = 'your-va';
$production = true;

$ipaymu = new iPaymu($apiKey, $va, $production);
```
### General


### Check Balance
```php
$balance = $iPaymu->checkBalance();
```

### Check Transaction
```php
$status = $iPaymu->checkTransaction($id);
```

#### Set URL
```php
$iPaymu->setURL([
    'ureturn' => 'https://your-website/thankyou_page',
    'unotify' => 'https://your-website/notify_page',
    'ucancel' => 'https://your-website/cancel_page',
]);
```

#### Set Buyer
```php

$buyer = $iPaymu->setBuyer([
    'name' => 'your-name',
    'phone' => 'your-phone',
    'email' => 'your-email',
]);
```

### Payment
There are 2 payment method: Payment Direct & Payment Redirect with the following parameters:
#####paymentMethod

• va => Virtual Account
• banktransfer => Transfer Bank
• cstore => Convenience Store
• cod => Cash on Delivery

#### paymentChannel
##### va
• bag => Bank Artha Graha
• bni => Bank Negara Indonesia
• cimb => Bank Cimb Niaga
• mandiri => Bank Mandiri
• bri => Bank BRI
• bca => Bank BCA
##### banktransfer
• bca => Bank Central Asia
##### cstore
• indomaret
• alfamart 
##### cod
• rpx

### Paramaters
| Parameter Request | Description                                                                                                | Type            | Mandatory |
| ----------------- | ---------------------------------------------------------------------------------------------------------- | --------------- | --------- |
| account           |                                                                                                            | numeric         | Y         |
| name              |                                                                                                            | string          | Y         |
| email             |                                                                                                            | string          | Y         |
| phone             |                                                                                                            | numeric         | Y         |
| amount            |                                                                                                            | numeric         | Y         |
| paymentMethod     | va, banktransfer, cstore, cod                                                                              | string          | Y         |
| paymentChannel    | <p>"**va:**" bag, bni, cimb, mandiri, bri, bca</p><p>"**cstore:**" indomaret, alfamart  </p>"**cod:**" rpx | string          | Y         |
| notifyUrl         | Return url when payment success                                                                            | string          | Y         |
| expired           | Expiration in hour                                                                                         | numeric         | N         |
| description       | Text description                                                                                           | string          | N         |
| referenceId       | Shopping cart order id                                                                                     | string          | N         |
| splitCount        | Multi payment (Using Split Payment API)                                                                    | numeric         | N         |
| product           | Product Name                                                                                               | [array] string  | Y         |
| qty               | Quantity                                                                                                   | [array] numeric | Y         |
| price             | Product Price                                                                                              | [array] numeric | Y         |
| weight            | Product Weight                                                                                             | [array] numeric | Y         |
| length            | Product Length                                                                                             | [array] numeric | Y         |
| width             | Product Width                                                                                              | [array] numeric | Y         |
| height            | Product Height                                                                                             | [array] numeric | Y         |
| deliveryArea      | Postal Code Customer                                                                                       | numeric         | Y         |
| deliveryAddress   | Customer Address                                                                                           | string          | Y         |
| pickupArea        | Postal Code Shipper (Default Merchant Postal Code)                                                         | numeric         | N         |
| pickupAddress     | Shipper Address (Default Merchant Address)                                                                 | string          | N         |

#### Add Product to Cart
First, please add product to shopping cart first before using this method
```php
$cart = $iPaymu->addCart([
        'name' => 'product-name',
        'quantity' => 'product-quantity',
        'price' => 'product-price',
]);
```
#### Set COD (Only if COD method)
```php
$ipaymu->setCOD([
        'pickupArea' => "76111",
        'pickupAddress' => "Denpasar",
]);
```
### Payment Direct
Payment direct method allows you to accept payment on your checkout page directly, this method works for any payment channel except for credit card.
```php
$cart = $ipaymu->directPayment($directData);
```

### Payment Redirect
In order accepting credit card, you must use Payment Redirect method. Upon checkout, you will be redirected to iPaymu.com payment page for further payment processing.
```php
$cart = $ipaymu->redirectPayment($directData);
```


