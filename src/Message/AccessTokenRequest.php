<?php

namespace Omnipay\Pesapal\Message;

use Omnipay\Common\Message\AbstractRequest;

class AccessTokenRequest extends AbstractRequest
{

    public function setConsumerKey($consumerKey)
    {
        $this->setParameter('consumerKey', $consumerKey);
    }

    public function setConsumerSecret($consumerSecret)
    {
        $this->setParameter('consumerSecret', $consumerSecret);
    }

    /**
     * Send the request with specified data
     *
     * @param  mixed $data The data to send
     * @return AccessTokenResponse
     */
    public function sendData($data)
    {
        $headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ];

        $httpResponse = $this->httpClient->request(
            'POST',
            $this->getParameter('apiUrl') . '/api/Auth/RequestToken',
            $headers,
            json_encode($data)
        );

        $tokenData = json_decode($httpResponse->getBody()->getContents(), true);

        $response = new AccessTokenResponse($this, $tokenData);
        return $response;
    }

    /**
     * Get the raw data array for this message. The format of this varies from gateway to
     * gateway, but will usually be either an associative array, or a SimpleXMLElement.
     *
     * @return mixed
     */
    public function getData()
    {
        return [
            'consumer_key' => $this->getParameter('consumerKey'),
            'consumer_secret' => $this->getParameter('consumerSecret'),
        ];
    }

    /**
     * @param string $apiUrl
     */
    public function setApiUrl($apiUrl)
    {
        $this->setParameter('apiUrl', $apiUrl);
    }
}
