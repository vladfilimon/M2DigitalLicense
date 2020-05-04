<?php
namespace Blockscape\DigitalLicense\Block\Customer\Products;

//use \Blockscape\DigitalLicense\Model\License\Purchased\Item;
use \Blockscape\DigitalLicense\Api\Data\DigitalLicenseInterface;
use \Blockscape\DigitalLicense\Api\DigitalLicenseRepositoryInterface;

class ListProducts extends \Magento\Framework\View\Element\Template
{
    /**
     * @var \Magento\Customer\Helper\Session\CurrentCustomer
     */
    protected $currentCustomer;

    /**
     * @var \Blockscape\DigitalLicense\Model\ResourceModel\License\Purchased\Item\Collection
     */
    protected $_licenseRepository;


    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Customer\Helper\Session\CurrentCustomer $currentCustomer
     * @param DigitalLicenseRepositoryInterface $licenseRepository
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Customer\Helper\Session\CurrentCustomer $currentCustomer,
        DigitalLicenseRepositoryInterface $licenseRepository,
        array $data = []
    ) {
        $this->currentCustomer = $currentCustomer;
        $this->_licenseRepository = $licenseRepository;
        parent::__construct($context, $data);
    }

    /**
     * Class constructor
     *
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $purchasedDigitalLicenses = $this->_licenseRepository->getCollectionByCustomer($this->currentCustomer->getCustomer());

        $this->setItems($purchasedDigitalLicenses);


        /*
        $purchased = $this->_licenseCollectionResource
            ->addFieldToFilter('customer_id', $this->currentCustomer->getCustomerId())
            ->addOrder('entity_id', 'desc');

        $this->setItems($purchased);
        */
    }

    /**
     * Enter description here...
     *
     * @return $this
     */
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        $items = $this->getItems();

        if ($items) {
            $pager = $this->getLayout()->createBlock(
                \Magento\Theme\Block\Html\Pager::class,
                'blockscape.customer.licenses.pager'
            )->setCollection(
                $items
            )->setPath('license/customer/products');
            $this->setChild('pager', $pager);
            $items->load();
        }
        /*
        foreach ($this->getItems() as $item) {
            $item->setPurchased($this->getPurchased()->getItemById($item->getPurchasedId()));
        }*/
        return $this;
    }

    /**
     * Return order view url
     *
     * @param integer $orderId
     * @return string
     */
    public function getOrderViewUrl($orderId)
    {
        return $this->getUrl('sales/order/view', ['order_id' => $orderId]);
    }

    /**
     * Enter description here...
     *
     * @return string
     */
    public function getBackUrl()
    {
        if ($this->getRefererUrl()) {
            return $this->getRefererUrl();
        }
        return $this->getUrl('customer/account/');
    }

    /**
     * Return url to download link
     *
     * @param Item $item
     * @return string
     */
    public function getDownloadUrl($item)
    {
        return $this->getUrl('downloadable/download/link', ['id' => $item->getId(), '_secure' => true]);
    }

    /**
     * Return true if target of link new window
     *
     * @return bool
     * @SuppressWarnings(PHPMD.BooleanGetMethodName)
     */
    public function getIsOpenInNewWindow()
    {
        return $this->_scopeConfig->isSetFlag(
            \Magento\Downloadable\Model\Link::XML_PATH_TARGET_NEW_WINDOW,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }
}
