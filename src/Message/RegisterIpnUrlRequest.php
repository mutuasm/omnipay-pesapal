<?php


namespace Omnipay\Pesapal\Message;

use Omnipay\Common\Message\AbstractRequest;

/**
 * @author Mwanzia Mutua <stevemtour@gmail.com>
 * @since 1.0.0
 */

class RegisterIpnUrlRequest extends AbstractRequest
{

    /**
     * Set instant payment notification url
     * @param $ipnUrl
     */
    public function setIpnUrl($ipnUrl)
    {
        $this->setParameter('ipnUrl', $ipnUrl);
    }

    /**
     * Send the request with specified data
     *
     * @param  mixed $data The data to send
     * @return RegisterIpnUrlResponse
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
            $this->getParameter('apiUrl') . '/api/URLSetup/RegisterIPN',
            $headers,
            json_encode($data)
        );

        $ipnData = json_decode($httpResponse->getBody()->getContents(), true);

        $response = new RegisterIpnUrlResponse($this, $ipnData);
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
            'url' => $this->getParameter('ipnUrl'),
            'ipn_notification_type' => 'GET'
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