<?php

/**
 * Class KL_Tracking_Helper_Tradedoubler
 */
class KL_Tracking_Helper_Tradedoubler extends Mage_Core_Helper_Abstract
{
    /**
     * @var int
     */
    protected $cookieLifetimeDays = 365;

    /**
     * @var string
     */
    protected $cookieName = 'tduid';

    /**
     * Fetch the cookie name
     *
     * @return string
     */
    public function getCookieName()
    {
        return $this->cookieName;
    }

    /**
     * Handle the event controller_action_predispatch
     * This will be used to save the "tduid" cookie for the user if provided
     */
    public function controllerPreDispatch()
    {
        /**
         * Check if parameter "tduid" is provided
         */
        if (Mage::app()->getRequest()->getParam($this->cookieName)) {
            $cookie = Mage::getSingleton('core/cookie');
            $cookie->set(
                $this->cookieName,
                Mage::app()->getRequest()->getParam('tduid'),
                time() + ($this->cookieLifetime * 86400),
                '/'
            );
        }
    }

    /**
     * Fetch cookie value
     *
     * @return string
     */
    public function getTduid()
    {
        return Mage::getModel('core/cookie')->get($this->cookieName);
    }

    /**
     * Return the event setting
     *
     * @return mixed
     */
    public function getEvent()
    {
        return Mage::helper('kltracking')->getConfig('tradedoubler', 'event_id');
    }

    /**
     * Return the organisation setting
     *
     * @return mixed
     */
    public function getOrganisation()
    {
        return Mage::helper('kltracking')->getConfig('tradedoubler', 'organization_id');
    }

    /**
     * Whether or not the prices should include VAT
     *
     * @return bool
     */
    public function priceShouldIncludeVat()
    {
        if (Mage::helper('kltracking')->getConfig('tradedoubler', 'price_include_vat') == '1') {
            return true;
        }

        return false;
    }

    /**
     * Build the tracking pixel
     *
     * @param $orderNumber
     * @param $amountExcludingVat
     * @param $amountIncludingVat
     * @param $currency
     *
     * @return string
     */
    public function getTradedoublerTrackingPixelURL($orderNumber, $amountExcludingVat, $amountIncludingVat, $currency)
    {
        /**
         * Assure we are tracking the person
         */
        if (!$this->getTduid()) {
            return '';
        }

        /**
         * Set the correct amount
         */
        if ($this->priceShouldIncludeVat()) {
            $amount = $amountIncludingVat;
        } else {
            $amount = $amountExcludingVat;
        }

        /**
         * Build the URL for the tracking pixel
         */
        $url = [
            'https://tbs.tradedoubler.com/report',
            '?organization=' . $this->getOrganisation(),
            '&event=' . $this->getEvent(),
            '&orderNumber=' . $orderNumber,
            '&orderValue=' . $amount,
            '&currency=' . $currency,
            '&tduid=' . $this->getTduid()
        ];

        return implode('', $url);
    }
}