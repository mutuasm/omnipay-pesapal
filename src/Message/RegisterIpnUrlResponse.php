<?php


namespace Omnipay\Pesapal\Message;

use Omnipay\Common\Message\AbstractResponse;

class RegisterIpnUrlResponse extends AbstractResponse
{
    /**
     * Is the response successful?
     *
     * @return boolean
     */
    public function isSuccessful()
    {
        return is_array($this->data)
            && isset($this->data['ipn_id']) && is_string($this->data['ipn_id']);
    }

    /**
     * @return string
     */
    public function getIpnId()
    {
        return $this->data['ipn_id'];
    }
}