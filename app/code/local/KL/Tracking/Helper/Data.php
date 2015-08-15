<?php

/**
 * Class KL_Tracking_Helper_Data
 */
class KL_Tracking_Helper_Data extends Mage_Core_Helper_Abstract
{
    /**
     * Shortcut for fetching settings
     *
     * @param $group
     * @param $field
     *
     * @return mixed
     */
    public function getConfig($group, $field)
    {
        return Mage::getStoreConfig('kltracking/' . $group . '/' . $field);
    }
}