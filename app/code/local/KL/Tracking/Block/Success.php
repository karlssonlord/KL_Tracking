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
     * When calling "toHtml" use the actual order
     *
     * @return string
     */
    public function _toHtml()
    {
        $this->setData('lookfor', 'order');
        return parent::_toHtml();
    }

    /**
     * When calling "toQuoteHtml" use the quote object
     *
     * @return string
     */
    public function toQuoteHtml()
    {
        $this->setData('lookfor', 'quote');
        return parent::_toHtml();
    }

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
         * Return the increment ID
         */
        if ($this->getOrder()->getIncrementId()) {
            return $this->getOrder()->getIncrementId();
        }

        /**
         * Return the reserved order ID when looking at a quote
         */
        if ($this->getOrder()->getReservedOrderId()) {
            return $this->getOrder()->getReservedOrderId();
        }

        /**
         * Fallback, use the entity ID (if any)
         */
        return $this->getOrder()->getId();
    }

    public function getOrderValueExcluding()
    {
    }

    public function getOrderValueIncludingTax()
    {
    }

    public function getOrderCurrency()
    {
    }

    public function getTradedoublerTrackingPixelURL()
    {
        /**
         * Temporary disabled function
         */
        return '';

        return Mage::helper('kltracking/tradedoubler')->getTradedoublerTrackingPixelURL(
            $this->getOrderNumber(),
            $this->getOrderValueExcluding(),
            $this->getOrderValueIncludingTax(),
            $this->getOrderCurrency()
        );
    }
}