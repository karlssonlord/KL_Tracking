<?php

/**
 * Class KL_Tracking_Block_Product
 */
class KL_Tracking_Block_Product extends KL_Tracking_Block_Abstract
{
    protected $_product;

    /**
     * Return the current product
     *
     * @return mixed
     */
    public function getCurrentProduct()
    {
        if (!$this->_product) {
            $this->_product = Mage::registry('current_product');
        }

        return $this->_product;
    }

    public function getStrippedShortDescription()
    {
        $description = $this->getCurrentProduct()->getShortDescription();
        $description = strip_tags($description);
        $description = str_replace('"', '\"', $description);

        return $description;
    }

    public function getPriceExlcudingTax()
    {
        return $this->helper('tax')->getPrice(
            $this->getCurrentProduct(),
            $this->getCurrentProduct()->getFinalPrice(),
            false
        );
    }
}