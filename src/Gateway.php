<?php

namespace Omnipay\Pesapal;

use Omnipay\Common\AbstractGateway;
use Omnipay\Common\Message\ResponseInterface;
use Omnipay\Pesapal\Message\AccessTokenRequest;
use Omnipay\Pesapal\Message\AccessTokenResponse;
use Omnipay\Pesapal\Message\PurchaseRequest;
use Omnipay\Pesapal\Message\PurchaseResponse;
use Omnipay\Pesapal\Message\RecurrenceRequest;
use Omnipay\Pesapal\Message\CancelRecurrenceRequest;
use Omnipay\Pesapal\Message\StatusRequest;
use Omnipay\Pesapal\Message\Notification;

/**
 * Pesapal payment gateway
 *
 * @package Omnipay\Pesapal
 * @see https://developer.pesapal.com/how-to-integrate/api-30-json/api-reference
 *
 *
 * @author Mwanzia Mutua <stevemtour@gmail.com>
 * @since 1.0.0
 */
class Gateway extends AbstractGateway
{

    const URL_SANDBOX = 'https://cybqa.pesapal.com/pesapalv3';
    const URL_PRODUCTION = 'https://pay.pesapal.com/v3';

    /**
     * Get gateway display name
     *
     * This can be used by carts to get the display name for each gateway.
     */
    public function getName()
    {
        return 'Pesapal';
    }

    /**
     * Get gateway short name
     *
     * This name can be used with GatewayFactory as an alias of the gateway class,
     * to create new instances of this gateway.
     */
    public function getShortName()
    {
        return 'pesapal';
    }

    /**
     * Define gateway parameters, in the following format:
     *
     * array(
     *     'username' => '', // string variable
     *     'testMode' => false, // boolean variable
     *     'landingPage' => array('billing', 'login'), // enum variable, first item is default
     * );
     */
    public function getDefaultParameters()
    {
        return [
            'consumer_key' => '',
            'consumer_secret' => '',
            'testMode' => true,
        ];
    }

    /**
     * Initialize gateway with parameters
     */
    public function initialize(array $parameters = [])
    {
        parent::initialize($parameters);
        $this->setApiUrl();
        return $this;
    }

    /**
     * @return AccessTokenResponse
     */
    public function getAccessToken()
    {
        /** @var AccessTokenRequest $request */
        $request = parent::createRequest(AccessTokenRequest::class, $this->getParameters());
        $response = $request->send();
        return $response;
    }

    /**
     * @param array $options
     * @return PurchaseResponse
     */
    public function purchase(array $options = array())
    {
        $this->setToken($this->getAccessToken()->getToken());
        $request = parent::createRequest(PurchaseRequest::class, $options);
        $response = $request->send();
        return $response;
    }

    /**
     * @param array $parameters
     * @return PurchaseResponse
     */
    public function completePurchase(array $parameters = array())
    {
        $this->setToken($this->getAccessToken()->getToken());
        $request = parent::createRequest(StatusRequest::class, $parameters);
        $response = $request->send();
        return $response;
    }

    /**
     * @param array $parameters
     * @return PurchaseResponse
     */
    public function status(array $parameters = array())
    {
        $this->setToken($this->getAccessToken()->getToken());
        $request = parent::createRequest(StatusRequest::class, $parameters);
        $response = $request->send();
        return $response;
    }


    public function acceptNotification()
    {
        $this->setToken($this->getAccessToken()->getToken());
        $parameters = ['transactionReference' => $this->httpRequest->query->get('id')];
        $request = parent::createRequest(StatusRequest::class, $parameters);
        /** @var PurchaseResponse $response */
        $response = $request->send();
        $parameters = [
            'code' => $response->getCode(),
            'transactionReference' => $response->getTransactionReference(),
            'transactionId' => $response->getTransactionId(),
            'data' => $response->getData()
        ];

        return new Notification($this->httpRequest, $this->httpClient, $parameters);
    }


    public function setConsumerKey($consumerKey)
    {
        $this->setParameter('consumerKey', $consumerKey);
    }

    public function setConsumerSecret($consumerSecret)
    {
        $this->setParameter('clientSecret', $consumerSecret);
    }

    public function setApiUrl()
    {
        if ($this->getTestMode()) {
            $apiUrl = self::URL_SANDBOX;
        } else {
            $apiUrl = self::URL_PRODUCTION;
        }

        $this->setParameter('apiUrl', $apiUrl);
    }

    private function setToken($token)
    {
        $this->setParameter('token', $token);
    }

}