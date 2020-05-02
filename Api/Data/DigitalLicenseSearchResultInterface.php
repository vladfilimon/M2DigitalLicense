<?php

namespace Blockscape\DigitalLicense\Api\Data;
use Magento\Framework\Data\SearchResultInterface;

interface DigitalLicenseSearchResultInterface extends SearchResultInterface
{
    /**
     * @return DigitalLicenseInterface[]
     */
    public function getItems();

    /**
     * @param DigitalLicenseInterface[] $items
     * @return void
     */
    public function setItems(array $items);
}