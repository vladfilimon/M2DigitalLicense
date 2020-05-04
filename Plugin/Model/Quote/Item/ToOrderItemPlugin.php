<?php
/**
 * @category Blockscape
 * @package Blockscape_DigitalLicense
 * @author Vlad Filimon Nastase <vlad_filimon@protonmail.com>
 * @copyright Copyright (c) 2020 Blockscape
 */

namespace Blockscape\DigitalLicense\Plugin\Model\Quote\Item;

use Magento\Sales\Api\Data\OrderItemInterface;
use Magento\Quote\Model\Quote\Item\ToOrderItem;
use Magento\Quote\Model\Quote\Item\AbstractItem;

class ToOrderItemPlugin
{
    /**
     * Attaches dog
     *
     * @param ToOrderItem $subject
     * @param OrderItemInterface $orderItem
     * @param AbstractItem $item
     * @param array $additional
     * @return OrderItemInterface
     * @throws \Magento\Framework\Exception\LocalizedException On insufficient license qty
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function afterConvert(
        ToOrderItem $subject,
        OrderItemInterface $orderItem,
        AbstractItem $quoteItem,
        $additional = []
    ) {
        $digitalLicenses = $quoteItem->getProduct()->getExtensionAttributes()->getDigitalLicenses();
        if (sizeof($digitalLicenses)) {
            if (sizeof($digitalLicenses) < $quoteItem->getQty()) {
                /**
                 * @TODO add translations for error message
                 * @TODO invalidate product from cart
                 */
                throw new \Magento\Framework\Exception\LocalizedException(__('ERR_INVALID_STOCK_NOT_ENOUGH_LICENSES'));
            }
            $itemDigitalLicenses = [];
            $i = 0;
            while ($i < $quoteItem->getQty()) {
                $itemDigitalLicenses[] = $digitalLicenses[$i];
                $i++;
            }
            if ($itemDigitalLicenses) {
                $orderItem->getExtensionAttributes()->setDigitalLicenses($itemDigitalLicenses);
            }
        }
        return $orderItem;
    }

}