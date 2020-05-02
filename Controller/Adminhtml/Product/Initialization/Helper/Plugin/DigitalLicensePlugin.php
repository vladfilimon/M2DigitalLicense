<?php
/**
 * @category Blockscape
 * @package Blockscape_DigitalLicense
 * @author Vlad Filimon Nastase <vlad_filimon@protonmail.com>
 * @copyright Copyright (c) 2020 Blockscape
 */

namespace Blockscape\DigitalLicense\Controller\Adminhtml\Product\Initialization\Helper\Plugin;
use \Magento\Catalog\Api\Data\ProductExtensionInterfaceFactory;
use \Magento\Catalog\Api\Data\ProductExtensionFactory;
use \Blockscape\DigitalLicense\Api\DigitalLicenseRepositoryInterface;
use \Blockscape\DigitalLicense\Model\DigitalLicenseFactory;
use Magento\Framework\App\RequestInterface;

class DigitalLicensePlugin
{
    /**
     * @var RequestInterface
     */
    private $request;

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
     * @param RequestInterface $request
     */
    public function __construct(
        ProductExtensionFactory $productExtensionFactory,
        DigitalLicenseFactory $digitalLicenseFactory,
        DigitalLicenseRepositoryInterface $digitalLicenseRepository,
        RequestInterface $request
    ) {

        $this->productExtensionFactory = $productExtensionFactory;
        $this->digitalLicenseFactory      = $digitalLicenseFactory;
        $this->digitalLicenseRepository   = $digitalLicenseRepository;
        $this->request = $request;
    }

    /**
     * @param \Magento\Catalog\Api\ProductRepositoryInterface $subject
     * @param \Magento\Catalog\Api\Data\ProductInterface $product
     * @return \Magento\Catalog\Api\Data\ProductInterface
     */
    public function afterGet
    (
        \Magento\Catalog\Api\ProductRepositoryInterface $subject,
        \Magento\Catalog\Api\Data\ProductInterface $product
    ) {
        $this->addDigitalLicensesToProduct($product);
        return $product;
    }

    /**
     * @param \Magento\Catalog\Api\ProductRepositoryInterface $subject
     * @param \Magento\Catalog\Api\Data\ProductInterface $product
     * @return \Magento\Catalog\Api\Data\ProductInterface
     */
    public function afterGetById
    (
        \Magento\Catalog\Api\ProductRepositoryInterface $subject,
        \Magento\Catalog\Api\Data\ProductInterface $product
    ) {
        $this->addDigitalLicensesToProduct($product);
        return $product;
    }

    /**
     * @param \Magento\Catalog\Api\ProductRepositoryInterface $subject
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Magento\Framework\Api\SearchResults
     */
    public function afterGetList
    (
        \Magento\Catalog\Api\ProductRepositoryInterface $subject,
        \Magento\Framework\Api\SearchResults $searchResult
    ) {
        /** @var \Magento\Catalog\Api\Data\ProductInterface $product */
        foreach ($searchResult->getItems() as $product) {
            $this->addDigitalLicensesToProduct($product);
        }

        return $searchResult;
    }

    /**
     * Prepare product to save
     *
     * @param \Magento\Catalog\Controller\Adminhtml\Product\Initialization\Helper $subject
     * @param \Magento\Catalog\Model\Product $product
     * @return \Magento\Catalog\Model\Product
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function afterInitialize(
        \Magento\Catalog\Controller\Adminhtml\Product\Initialization\Helper $subject,
        \Magento\Catalog\Model\Product $product
    ) {
        $digitalLicenseData = $this->request->getPost('digital_license');
        $extension = $product->getExtensionAttributes();
        $prdDigitalLicenses = $extension->getDigitalLicenses();
        foreach ($prdDigitalLicenses as $prdLicense) {
            $found = false;
            foreach ($digitalLicenseData['licenses'] as $license) {
                if (isset ($license['license_id']) &&
                    $prdLicense->getId() == $license['license_id']) {
                    $found = true;
                    break;
                }
            }

            if (!$found) {
                /**
                 * @TODO soft delete
                 */
                $this->digitalLicenseRepository->delete($prdLicense);
            }
        }

        foreach ($digitalLicenseData['licenses'] as $license) {
            if (!isset($license['license_id'])) {
                $newLicense = $this->digitalLicenseFactory->create();
                /**
                 * @TODO set just the license text not whole data
                 */
                $newLicense->setData($license);
                $newLicense->setProductId($product->getId());
                $newLicense->setIsActive(true);

                $this->digitalLicenseRepository->save($newLicense);
            }
        }
        return $product;
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

        $licensesArray = [];
        foreach ($this->digitalLicenseRepository->getByProduct($product)->getItems() as $license) {
            $licensesArray[] = $license;
        }

        $extensionAttributes->setDigitalLicenses(
            $licensesArray
        );

        $product->setExtensionAttributes($extensionAttributes);

        return $this;
    }

}
