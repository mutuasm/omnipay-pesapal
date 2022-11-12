<?php

namespace Omnipay\Pesapal\Message;

use Omnipay\Common\Message\AbstractResponse;

/**
 * @author Mwanzia Mutua <stevemtour@gmail.com>
 * @since 1.0.0
 */

class AccessTokenResponse extends AbstractResponse
{

    /**
     * Is the response successful?
     *
     * @return boolean
     */
    public function isSuccessful()
    {
        return is_array($this->data)
            && isset($this->data['token']) && is_string($this->data['access_token']);
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->data['token'];
    }

}