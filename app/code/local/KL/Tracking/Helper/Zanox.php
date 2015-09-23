<?php

/**
 * Class KL_Tracking_Helper_Zanox
 */
class KL_Tracking_Helper_Zanox extends Mage_Core_Helper_Abstract
{
    /**
     * @var string
     */
    protected $sessionName = 'zanpid';

    /**
     * Handle the event controller_action_predispatch
     * This will be used to save the "zanpid" session value for the user if provided
     */
    public function controllerPreDispatch()
    {
        /**
         * Check if parameter is provided
         */
        if (Mage::app()->getRequest()->getParam($this->sessionName)) {
            Mage::getSingleton('core/session')->setData(
                $this->sessionName,
                Mage::app()->getRequest()->getParam($this->sessionName)
            );
        }

        return $this;
    }

    /**
     * Fetch Partner ID from session
     *
     * @return string
     */
    public function getPartnerId()
    {
        $partnerId = Mage::getSingleton('core/session')->getData($this->sessionName);
        if (!$partnerId) {
            return '[[XXX]]]';
        }

        return $partnerId;
    }
}