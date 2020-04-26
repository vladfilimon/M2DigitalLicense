<?php
/**
 * @category Blockscape
 * @package Blockscape_DigitalLicense
 * @author Vlad Filimon Nastase <vlad_filimon@protonmail.com>
 * @copyright Copyright (c) 2020 Blockscape
 */


namespace Blockscape\DigitalLicense\Model;

/**
 * DigitalLicense Class
 */
class DigitalLicense extends \Magento\Framework\Model\AbstractExtensibleModel implements \Magento\Framework\DataObject\IdentityInterface, \Blockscape\DigitalLicense\Api\Data\DigitalLicenseInterface
{

    const NOROUTE_ENTITY_ID = 'no-route';

    const CACHE_TAG = 'blockscape_digitallicense_digitallicense';

    protected $_cacheTag = 'blockscape_digitallicense_digitallicense';

    protected $_eventPrefix = 'blockscape_digitallicense_digitallicense';

    /**
     * set resource model
     */
    public function _construct()
    {
        $this->_init(\Blockscape\DigitalLicense\Model\ResourceModel\DigitalLicense::class);
    }

    /**
     * Load No-Route Indexer.
     *
     * @return $this
     */
    public function noRouteReasons()
    {
        return $this->load(self::NOROUTE_ENTITY_ID, $this->getIdFieldName());
    }

    /**
     * Get identities.
     *
     * @return []
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG.'_'.$this->getId()];
    }

    /**
     * Set LicenseId
     *
     * @param int $licenseId
     * @return \Blockscape\DigitalLicense\Api\Data\DigitalLicenseInterface
     */
    public function setLicenseId($licenseId)
    {
        return $this->setData(self::LICENSE_ID, $licenseId);
    }

    /**
     * Get LicenseId
     *
     * @return int
     */
    public function getLicenseId()
    {
        return parent::getData(self::LICENSE_ID);
    }

    /**
     * Set ProductId
     *
     * @param int $productId
     * @return \Blockscape\DigitalLicense\Api\Data\DigitalLicenseInterface
     */
    public function setProductId($productId)
    {
        return $this->setData(self::PRODUCT_ID, $productId);
    }

    /**
     * Get ProductId
     *
     * @return int
     */
    public function getProductId()
    {
        return parent::getData(self::PRODUCT_ID);
    }

    /**
     * Set OrderId
     *
     * @param int $orderId
     * @return \Blockscape\DigitalLicense\Api\Data\DigitalLicenseInterface
     */
    public function setOrderId($orderId)
    {
        return $this->setData(self::ORDER_ID, $orderId);
    }

    /**
     * Get OrderId
     *
     * @return int
     */
    public function getOrderId()
    {
        return parent::getData(self::ORDER_ID);
    }

    /**
     * Set CustomerId
     *
     * @param int $customerId
     * @return \Blockscape\DigitalLicense\Api\Data\DigitalLicenseInterface
     */
    public function setCustomerId($customerId)
    {
        return $this->setData(self::CUSTOMER_ID, $customerId);
    }

    /**
     * Get CustomerId
     *
     * @return int
     */
    public function getCustomerId()
    {
        return parent::getData(self::CUSTOMER_ID);
    }

    /**
     * Set LicenseText
     *
     * @param string $licenseText
     * @return \Blockscape\DigitalLicense\Api\Data\DigitalLicenseInterface
     */
    public function setLicenseText($licenseText)
    {
        return $this->setData(self::LICENSE_TEXT, $licenseText);
    }

    /**
     * Get LicenseText
     *
     * @return string
     */
    public function getLicenseText()
    {
        return parent::getData(self::LICENSE_TEXT);
    }


    /**
     * {@inheritdoc}
     *
     * @return \Blockscape\DigitalLicense\Api\Data\LicenseExtensionInterface $extensionAttributes
     */
    public function getExtensionAttributes()
    {
        return $this->_getExtensionAttributes();
    }

    /**
     * {@inheritdoc}
     *
     * @param \Blockscape\DigitalLicense\Api\Data\LicenseExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(\Blockscape\DigitalLicense\Api\Data\LicenseExtensionInterface $extensionAttributes)
    {
        return $this->_setExtensionAttributes($extensionAttributes);
    }
}

