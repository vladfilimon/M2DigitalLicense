<?php
/**
 * @category Blockscape
 * @package Blockscape_DigitalLicense
 * @author Vlad Filimon Nastase <vlad_filimon@protonmail.com>
 * @copyright Copyright (c) 2020 Blockscape
 */


namespace Blockscape\DigitalLicense\Api\Data;

/**
 * DigitalLicense Interface
 */
interface DigitalLicenseInterface extends
    \Magento\Framework\DataObject\IdentityInterface,
    \Magento\Framework\Api\ExtensibleDataInterface
{

    const LICENSE_ID = 'license_id';

    const PRODUCT_ID = 'product_id';

    const ORDER_ITEM_ID = 'order_item_id';

    const CUSTOMER_ID = 'customer_id';

    const LICENSE_TEXT = 'license_text';

    /**
     * Set LicenseId
     *
     * @param int $licenseId
     * @return \Blockscape\DigitalLicense\Api\Data\DigitalLicenseInterface
     */
    public function setLicenseId($licenseId);
    /**
     * Get LicenseId
     *
     * @return int
     */
    public function getLicenseId();
    /**
     * Set ProductId
     *
     * @param int $productId
     * @return \Blockscape\DigitalLicense\Api\Data\DigitalLicenseInterface
     */
    public function setProductId($productId);
    /**
     * Get ProductId
     *
     * @return int
     */
    public function getProductId();
    /**
     * Set Order Item Id
     *
     * @param int $orderItemId
     * @return \Blockscape\DigitalLicense\Api\Data\DigitalLicenseInterface
     */
    public function setOrderItemId($orderItemId);
    /**
     * Get Order Item Id
     *
     * @return int
     */
    public function getOrderItemId();
    /**
     * Set CustomerId
     *
     * @param int $customerId
     * @return \Blockscape\DigitalLicense\Api\Data\DigitalLicenseInterface
     */
    public function setCustomerId($customerId);
    /**
     * Get CustomerId
     *
     * @return int
     */
    public function getCustomerId();
    /**
     * Set LicenseText
     *
     * @param string $licenseText
     * @return \Blockscape\DigitalLicense\Api\Data\DigitalLicenseInterface
     */
    public function setLicenseText($licenseText);
    /**
     * Get LicenseText
     *
     * @return string
     */
    public function getLicenseText();

    /**
     * Retrieve existing extension attributes object or create a new one.
     *
     * @return \Blockscape\DigitalLicense\Api\Data\DigitalLicenseExtensionInterface|null
     */
    public function getExtensionAttributes();

    /**
     * Set an extension attributes object.
     *
     * @param \Blockscape\DigitalLicense\Api\Data\DigitalLicenseExtensionInterface $extensionAttributes
     * @return \Blockscape\DigitalLicense\Api\Data\DigitalLicenseInterface
     */
    public function setExtensionAttributes(\Blockscape\DigitalLicense\Api\Data\DigitalLicenseExtensionInterface $extensionAttributes);
}
