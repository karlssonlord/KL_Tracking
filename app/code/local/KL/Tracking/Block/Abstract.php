<?php

/**
 * Class KL_Tracking_Block_Abstract
 */
class KL_Tracking_Block_Abstract extends Mage_Core_Block_Template
{
    /**
     * Check if integration is enabled
     *
     * @param $trackingType
     *
     * @return bool
     */
    public function isEnabled($trackingType)
    {
        /**
         * Fetch value from config
         */
        $configValue = Mage::getStoreConfig('kltracking/integrations/' . $trackingType);

        if ($configValue == '1') {
            return true;
        }

        return false;
    }

}