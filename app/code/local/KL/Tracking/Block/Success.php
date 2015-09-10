<?php

/**
 * Class KL_Tracking_Block_Success
 */
class KL_Tracking_Block_Success extends KL_Tracking_Block_Abstract
{
    /**
     * @var
     */
    protected $order = null;

    /**
     * Return the order or quote object
     *
     * @return null
     */
    public function getOrder()
    {
        if (is_null($this->order)) {
            if ($this->getData('lookfor') == 'order') {
                $this->order = Mage::getModel('sales/order')->load(
                    Mage::getSingleton('checkout/session')->getLastOrderId()
                );
            } else {
                $quoteId = Mage::getSingleton('checkout/session')->getLastQuoteId();
                if ($quoteId) {
                    $this->order = Mage::getModel('sales/quote')->load($quoteId);
                }
            }
        }

        return $this->order;
    }

    /**
     * Return the order number
     */
    public function getOrderNumber()
    {
        /**
         * Assure it's an object
         */
        if (!is_object($this->getOrder())) {
            return null;
        }

        /**
         * Return the reserved order ID when looking at a quote
         */
        if ($this->getOrder()->getReservedOrderId()) {
            return $this->getOrder()->getReservedOrderId();
        }

        /**
         * Return the increment ID
         */
        if ($this->getOrder()->getIncrementId()) {
            return $this->getOrder()->getIncrementId();
        }

        /**
         * Fallback, use the entity ID (if any)
         */
        return $this->getOrder()->getId();
    }

    /**
     * Total order value excluding tax
     *
     * @return float
     */
    public function getOrderValueExcludingTax()
    {
        /**
         * Assure it's an object
         */
        if (!is_object($this->getOrder())) {
            return null;
        }

        return ($this->getOrderValueIncludingTax() - $this->getOrder()->getTaxAmount());
    }

    /**
     * Total order value including tax
     *
     * @return float
     */
    public function getOrderValueIncludingTax()
    {
        /**
         * Assure it's an object
         */
        if (!is_object($this->getOrder())) {
            return null;
        }

        return floatval($this->getOrder()->getGrandTotal());
    }

    /**
     * Order currency code
     *
     * @return string
     */
    public function getOrderCurrency()
    {
        /**
         * Assure it's an object
         */
        if (!is_object($this->getOrder())) {
            return null;
        }

        /**
         * Fetch currency from order
         */
        $currency = (string)$this->getOrder()->getOrderCurrencyCode();

        /**
         * If no currency were found, try the value stored on quotes
         */
        if (!trim($currency)) {
            $currency = (string)$this->getOrder()->getQuoteCurrencyCode();
        }

        return $currency;
    }

    /**
     * Fetch TradeDoubler tracking pixel
     *
     * @return string
     */
    public function getTradedoublerTrackingPixelURL()
    {
        /**
         * Assure it's an object
         */
        if (!is_object($this->getOrder())) {
            return null;
        }

        return Mage::helper('kltracking/tradedoubler')->getTradedoublerTrackingPixelURL(
            $this->getOrderNumber(),
            $this->getOrderValueExcludingTax(),
            $this->getOrderValueIncludingTax(),
            $this->getOrderCurrency()
        );
    }
}