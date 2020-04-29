<?php
/**
 * @category Blockscape
 * @package Blockscape_DigitalLicense
 * @author Vlad Filimon Nastase <vlad_filimon@protonmail.com>
 * @copyright Copyright (c) 2020 Blockscape
 */

namespace Blockscape\DigitalLicense\Controller\Adminhtml\Product\Initialization\Helper\Plugin;
use \Magento\Catalog\Api\Data\ProductExtensionInterfaceFactory;
use \Magento\Catalog\Api\Data\ProductExtensionInterface;
use \Blockscape\DigitalLicense\Model\ResourceModel\DigitalLicense\Collection;
use \Magento\Catalog\Api\Data\ProductInterface;
use \Magento\Catalog\Api\Data\ProductExtensionFactory;
use \Blockscape\DigitalLicense\Api\DigitalLicenseRepositoryInterface;
use \Blockscape\DigitalLicense\Api\Data\DigitalLicenseInterface;
use \Blockscape\DigitalLicense\Model\DigitalLicenseFactory;


class DigitalLicensePlugin
{
    /**
     * @var ProductExtensionInterfaceFactory
     */
    private $productExtensionFactory;

    /**
     * @var DigitalLicenseFactory
     */
    private $digitalLicenseFactory;

    /**
     * @var DigitalLicenseRepositoryInterface
     */
    private $digitalLicenseRepository;

    /**
     * @param ProductExtensionFactory $productExtensionFactory
     * @param DigitalLicenseFactory $digitalLicenseFactory
     * @param DigitalLicenseRepositoryInterface $digitalLicenseRepository
     */
    public function __construct(
        ProductExtensionFactory $productExtensionFactory,
        DigitalLicenseFactory $digitalLicenseFactory,
        \Blockscape\DigitalLicense\Model\DigitalLicenseRepository $digitalLicenseRepository
    ) {

        $this->productExtensionFactory = $productExtensionFactory;
        $this->digitalLicenseFactory      = $digitalLicenseFactory;
        $this->digitalLicenseRepository   = $digitalLicenseRepository;
    }

    public function afterGetExtensionAttributes(
        ProductInterface $entity,
        ProductExtensionInterface $extension = null
    ) {
        if ($extension === null) {
            $extension = $this->productExtensionFactory->create();
        }

        $extension->setDigitalLicenses(
            $this->digitalLicenseRepository->getByProduct($entity)
        );

        return $extension;
    }

}
