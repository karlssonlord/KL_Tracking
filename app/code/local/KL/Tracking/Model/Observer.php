<?php

/**
 * Class KL_Tracking_Model_Observer
 */
class KL_Tracking_Model_Observer
{
    /**
     * Handle the event "controller_action_predispatch"
     *
     * @param $observer
     *
     * @return mixed
     */
    public function controllerPreDispatch($observer)
    {
        /**
         * Allow Tradedoubler to handle it's magic
         */
        Mage::helper('kltracking/tradedoubler')->controllerPreDispatch();

        return $observer;
    }
}