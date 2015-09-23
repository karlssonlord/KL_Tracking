<?php

/**
 * Class KL_Tracking_Block_Category
 */
class KL_Tracking_Block_Category extends KL_Tracking_Block_Abstract
{
    /**
     * Return the current product
     *
     * @return mixed
     */
    public function getCurrentCategory()
    {
        return Mage::registry('current_category');
    }
}