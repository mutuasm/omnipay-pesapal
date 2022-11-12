# Omnipay: Pesapal

**Pesapal API v3 driver for the Omnipay PHP payment processing library**

[Omnipay](https://github.com/thephpleague/omnipay) is a framework agnostic, multi-gateway payment
processing library for PHP 7.2+. This package implements the latest Pesapal API support for Omnipay.

Pesapal gateway API [documentation](https://developer.pesapal.com/how-to-integrate/api-30-json/api-reference/)

## Installation

This package is installed via [Composer](http://getcomposer.org/). To install, simply add it
to your `composer.json` file:

```
composer require mwanziamutua/pesapal
```

## Basic Usage

The following gateways are provided by this package:

* Pesapal

You need to set your `consumerKey`, and `consumerSecret`. Setting `testMode` to true will use the `sandbox` environment.

Process your customer order like so:


```php
$gateway = GatewayFactory::createInstance($consumerKey, $consumerSecret, true);

try {
    $orderNo = uniqid('', true);
    $returnUrl = 'http://localhost:80/gateway-return.php';
    $notifyUrl = 'http://127.0.0.1/online-payments/uuid/notify';
    $ipnId = ' b62dbd97-3b95-43d2-8969-df616360f0ab';
    $description = 'Shopping at myAwesomeStore.com';

    $pesapalOrder = [
        'purchaseData' => [
            'id' => $orderNo,
            'amount'            => 150,
            'currency'          => 'KES',
            'description' => $description,
            'callback_url' => $returnUrl,
            'notification_id' => $ipnId,
            'billing_address'  => [
                "email_address" => "john.doe@example.com",
                "phone_number" => null,
                "country_code" => "",
                "first_name" => "John",
                "middle_name" => "",
                "last_name" => "Doe",
                "line_1" => "",
                "line_2" => "",
                "city" => "",
                "state" => "",
                "postal_code" => null,
                "zip_code" => null
            ]
        ],
    ];


    $response = $gateway->purchase($pesapalOrder);
```

For general usage instructions, please see the main [Omnipay](https://github.com/thephpleague/omnipay)
repository.


## Support

If you are having general issues with Omnipay, we suggest posting on
[Stack Overflow](http://stackoverflow.com/). Be sure to add the
[omnipay tag](http://stackoverflow.com/questions/tagged/omnipay) so it can be easily found.

If you want to keep up to date with release anouncements, discuss ideas for the project,
or ask more detailed questions, there is also a [mailing list](https://groups.google.com/forum/#!forum/omnipay) which
you can subscribe to.

If you believe you have found a bug, please report it using the [GitHub issue tracker](https://github.com/mwanziamutua/omnipay-pesapal/issues),
or better yet, fork the library and submit a pull request.