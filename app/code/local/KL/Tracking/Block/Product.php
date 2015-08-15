<?php

/**
 * Class KL_Tracking_Block_Product
 */
class KL_Tracking_Block_Product extends KL_Tracking_Block_Abstract
{
    /**
     * Return the current product
     *
     * @return mixed
     */
    public function getCurrentProduct()
    {
        return Mage::registry('current_product');
    }
}