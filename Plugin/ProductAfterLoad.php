<?php
/**
 * @category Blockscape
 * @package Blockscape_DigitalLicense
 * @author Vlad Filimon Nastase <vlad_filimon@protonmail.com>
 * @copyright Copyright (c) 2020 Blockscape
 */

namespace Blockscape\DigitalLicense\Plugin;

use Magento\Catalog\Api\Data\ProductExtensionFactory;
use \Magento\Catalog\Api\Data\ProductExtensionInterfaceFactory;
use \Blockscape\DigitalLicense\Api\DigitalLicenseRepositoryInterface;

class ProductAfterLoad
{
    /**
     * @param ProductExtensionFactory $productExtensionFactory
     * @param DigitalLicenseRepositoryInterface $digitalLicenseRepository
     */
    public function __construct(
        ProductExtensionInterfaceFactory $productExtensionFactory,
        DigitalLicenseRepositoryInterface $digitalLicenseRepository
    ) {

        $this->productExtensionFactory = $productExtensionFactory;
        $this->digitalLicenseRepository   = $digitalLicenseRepository;
    }
    /**
     * Add license information to the product's extension attributes
     */
    public function afterGetItems(\Magento\Catalog\Model\ResourceModel\Product\Collection $subject ,array $result)
    {
        foreach ($result as $product) {
            $this->addDigitalLicensesToProduct($product);
        }
        return $result;
    }

    /**
     * Add license information to the product's extension attributes
     */
    public function afterGetById(\Magento\Catalog\Model\ResourceModel\Product\Collection $subject ,array $result)
    {
        foreach ($result as $product) {
            $this->addDigitalLicensesToProduct($product);
        }
        return $result;
    }


    /**
     * Adds all active (not soft deleted) licenses to the product
     *
     * @param \Magento\Catalog\Api\Data\ProductInterface $product
     * @return self
     */
    protected function addDigitalLicensesToProduct(\Magento\Catalog\Api\Data\ProductInterface $product)
    {
        $extensionAttributes = $product->getExtensionAttributes();
        if (empty($extensionAttributes)) {
            $extensionAttributes = $this->productExtensionFactory->create();
        }
        if ($product->getExtensionAttributes()->getDigitalLicenses() == NULL) {
            $licensesArray = [];
            foreach ($this->digitalLicenseRepository->getByProduct($product)->getItems() as $license) {
                $licensesArray[] = $license;
            }
            $extensionAttributes->setDigitalLicenses(
                $licensesArray
            );
        }
        $product->setExtensionAttributes($extensionAttributes);
        return $this;
    }
}
