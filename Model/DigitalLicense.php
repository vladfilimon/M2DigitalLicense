<?php
/**
 * @category Blockscape
 * @package Blockscape_DigitalLicense
 * @author Vlad Filimon Nastase <vlad_filimon@protonmail.com>
 * @copyright Copyright (c) 2020 Blockscape
 */


namespace Blockscape\DigitalLicense\Model;

use Magento\Framework\Api\AttributeValueFactory;
use Magento\Framework\Api\ExtensionAttributesFactory;

/**
 * DigitalLicense Class
 */
class DigitalLicense extends \Magento\Framework\Model\AbstractExtensibleModel
    implements \Blockscape\DigitalLicense\Api\Data\DigitalLicenseInterface
{

    const NOROUTE_ENTITY_ID = 'no-route';

    const CACHE_TAG = 'blockscape_digitallicense_digitallicense';

    protected $_cacheTag = 'blockscape_digitallicense_digitallicense';

    protected $_eventPrefix = 'blockscape_digitallicense_digitallicense';

    protected $_productRepository;

    protected $_orderItemRepository;

    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        ExtensionAttributesFactory $extensionFactory,
        AttributeValueFactory $customAttributeFactory,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        array $data = [],
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository,
        \Magento\Sales\Api\OrderItemRepositoryInterface $orderItemRepository
    ) {
        parent::__construct($context, $registry, $extensionFactory, $customAttributeFactory, $resource,
            $resourceCollection, $data);
        $this->_productRepository = $productRepository;
        $this->_orderItemRepository = $orderItemRepository;
    }

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
     * Retrieve product
     *
     * @return \Magento\Catalog\Model\Product|null
     */
    public function getProduct()
    {
        if (!$this->hasData('product')) {
            try {
                $product = $this->_productRepository->getById($this->getProductId());
            } catch (\Magento\Framework\Exception\NoSuchEntityException $noEntityException) {
                $product = null;
            }
            $this->setProduct($product);
        }
        return $this->getData('product');
    }

    /**
     * Retrieve order
     *
     * @return \Magento\Sales\Api\Data\OrderItemInterface|null
     */
    public function getOrderItem()
    {
        if (!$this->hasData('order_item')) {
            try {
                $order = $this->_orderItemRepository->get($this->getOrderItemId());
            } catch (\Magento\Framework\Exception\NoSuchEntityException $noEntityException) {
                $order = null;
            }
            $this->setOrderItem($order);
        }
        return $this->getData('order_item');
    }

    /**
     * Set OrderItemId
     *
     * @param int $orderItemId
     * @return \Blockscape\DigitalLicense\Api\Data\DigitalLicenseInterface
     */
    public function setOrderItemId($orderItemId)
    {
        return $this->setData(self::ORDER_ITEM_ID, $orderItemId);
    }

    /**
     * Get OrderItemId
     *
     * @return int
     */
    public function getOrderItemId()
    {
        return parent::getData(self::ORDER_ITEM_ID);
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
     * @return \Blockscape\DigitalLicense\Api\Data\DigitalLicenseExtensionInterface $extensionAttributes
     */
    public function getExtensionAttributes()
    {
        return $this->_getExtensionAttributes();
    }

    /**
     * {@inheritdoc}
     *
     * @param \Blockscape\DigitalLicense\Api\Data\DigitalLicenseExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(
        \Blockscape\DigitalLicense\Api\Data\DigitalLicenseExtensionInterface $extensionAttributes
    )
    {
        return $this->_setExtensionAttributes($extensionAttributes);
    }
}

