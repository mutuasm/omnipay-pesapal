<?php


namespace Omnipay\Pesapal\Message;

use Omnipay\Common\Message\AbstractResponse;

/**
 * @author Mwanzia Mutua <stevemtour@gmail.com>
 * @since 1.0.0
 */

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