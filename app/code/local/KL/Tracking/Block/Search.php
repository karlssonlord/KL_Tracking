<?php

/**
 * Class KL_Tracking_Block_Search
 */
class KL_Tracking_Block_Search extends KL_Tracking_Block_Abstract
{
    /**
     * Return query search string
     *
     * @return string
     */
    public function getQueryString()
    {
        return Mage::helper('catalogsearch')->getQueryText();
    }
}