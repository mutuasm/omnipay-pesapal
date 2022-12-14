<?php

namespace Omnipay\Pesapal;

use Omnipay\Omnipay;
use Symfony\Component\HttpFoundation\Request;

/**
 * @author Mwanzia Mutua <stevemtour@gmail.com>
 * @since 1.0.0
 */

class GatewayFactory
{
    /**
     * @param string $consumerKey
     * @param string $consumerSecret
     * @param bool $testMode
     * @param Request|null $httpRequest
     * @return Gateway
     */
    public static function createInstance($consumerKey, $consumerSecret, $testMode = true, $httpRequest = null)
    {
        $gateway = Omnipay::create('Pesapal', null, $httpRequest);
        $gateway->initialize([
            'consumerKey' => $consumerKey,
            'consumerSecret' => $consumerSecret,
            'testMode' => $testMode,
        ]);

        return $gateway;
    }
}
