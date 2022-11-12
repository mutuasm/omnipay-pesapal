<?php

namespace Omnipay\Pesapal\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RedirectResponseInterface;

class PurchaseResponse extends AbstractResponse implements RedirectResponseInterface
{
    /**
     * Is the response successful?
     *
     * @return boolean
     */
    public function isSuccessful()
    {
        $redirectUrl = $this->getRedirectUrl();
        return is_string($redirectUrl);
    }

    /**
     * Gets the redirect target url.
     */
    public function getRedirectUrl()
    {
        if (!is_array($this->data) || !isset($this->data['return_url']) || !is_string($this->data['return_url'])) {
            return null;
        }
        return $this->data['return_url'];
    }

    /**
     * Get the required redirect method (either GET or POST).
     */
    public function getRedirectMethod()
    {
        return 'GET';
    }

    /**
     * Gets the redirect form data array, if the redirect method is POST.
     */
    public function getRedirectData()
    {
        return null;
    }

    public function getCode()
    {
        if (isset($this->data['status'])) {
            return $this->data['status'];
        }
        return null;
    }

    public function getTransactionReference()
    {
        if (isset($this->data['order_tracking_id']) && !empty(isset($this->data['order_tracking_id']))) {
            return (string) $this->data['order_tracking_id'];
        }
        return null;
    }

    public function getTransactionId()
    {
        if (isset($this->data['merchant_reference']) && !empty($this->data['merchant_reference'])) {
            return (string) $this->data['merchant_reference'];
        }
        return null;
    }

}