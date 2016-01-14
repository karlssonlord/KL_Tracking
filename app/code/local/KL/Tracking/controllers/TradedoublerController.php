<?php

class KL_Tracking_TradedoublerController extends Mage_Core_Controller_Front_Action
{
    public function IndexAction()
    {
        $layout = Mage::getSingleton('core/layout');
        $html = $layout
            ->createBlock('kltracking/tradedoublerredirect')
            ->setTemplate('kltracking/tradedoubler_redirect.phtml')
            ->toHtml();

        echo $html;
    }
}