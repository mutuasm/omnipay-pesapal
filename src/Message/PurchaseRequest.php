<?php

namespace Omnipay\Pesapal\Message;

use Omnipay\Common\Message\AbstractRequest;

/**
 * @author Mwanzia Mutua <stevemtour@gmail.com>
 * @since 1.0.0
 */

class PurchaseRequest extends AbstractRequest
{

    /**
     * Get the raw data array for this message. The format of this varies from gateway to
     * gateway, but will usually be either an associative array, or a SimpleXMLElement.
     *
     * @return mixed
     */
    public function getData()
    {
        return $this->getParameter('purchaseData');
    }

    /**
     * Send the request with specified data
     *
     * @param  mixed $data The data to send
     * @return PurchaseResponse
     */
    public function sendData($data)
    {
        $headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => $this->getParameter('token'),
        ];

        $httpResponse = $this->httpClient->request(
            'POST',
            $this->getParameter('apiUrl') . '/api/Transactions/SubmitOrderRequest',
            $headers,
            json_encode($data)
        );

        $purchaseResponseData = json_decode($httpResponse->getBody()->getContents(), true);

        $response = new PurchaseResponse($this, $purchaseResponseData);
        return $response;
    }

    /**
     * @param string $token
     */
    public function setToken($token)
    {
        $this->setParameter('token', $token);
    }

    public function setPurchaseData($data)
    {
        $this->setParameter('purchaseData', $data);
    }

    /**
     * @param string $apiUrl
     */
    public function setApiUrl($apiUrl)
    {
        $this->setParameter('apiUrl', $apiUrl);
    }
}
