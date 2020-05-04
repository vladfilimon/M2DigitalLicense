<?php
/**
 * @category Blockscape
 * @package Blockscape_DigitalLicense
 * @author Vlad Filimon Nastase <vlad_filimon@protonmail.com>
 * @copyright Copyright (c) 2020 Blockscape
 */

namespace Blockscape\DigitalLicense\Model\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Message\ManagerInterface;
use Blockscape\DigitalLicense\Api\DigitalLicenseRepositoryInterface;

class SalesOrderPlaceAfter implements ObserverInterface
{
    protected $_licenseRepository;

    /**
     * @param \Magento\Framework\ObjectManagerInterface $objectManager
     */
    public function __construct(
        DigitalLicenseRepositoryInterface $licenseRepository
    ) {
        $this->_licenseRepository = $licenseRepository;
    }

    /**
    * @param Observer $observer
    * @return void
    */
    public function execute(Observer $observer)
    {
        /**
         * @TODO check if digital license module enabled
         */

        /** @var \Magento\Sales\Model\Order $order */
        $order = $observer->getEvent()->getOrder();
        foreach($order->getAllItems() as $item) {
            var_dump($item->getExtensionAttributes()->getDigitalLicenses());
            foreach ($item->getExtensionAttributes()->getDigitalLicenses() as $itemLicense) {
                $itemLicense->setOrderItemId($item->getItemId());
                $this->_licenseRepository->save($itemLicense);
            }
        }
        die(__METHOD__);
    }
}