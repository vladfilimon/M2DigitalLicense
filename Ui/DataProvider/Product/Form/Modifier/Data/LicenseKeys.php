<?php

namespace Blockscape\DigitalLicense\Ui\DataProvider\Product\Form\Modifier\Data;

use \Magento\Framework\Escaper;
use Blockscape\DigitalLicense\Model\Product\Type;
use Magento\Catalog\Model\Locator\LocatorInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\UrlInterface;
use Magento\Downloadable\Model\Link as LinkModel;
use Magento\Downloadable\Api\Data\LinkInterface;
use Blockscape\DigitalLicense\Api\Data\DigitalLicenseInterface;

/**
 * Class Links
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class LicenseKeys
{
    /**
     * @var LocatorInterface
     */
    protected $locator;

    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @var DigitalLicenseInterface
     */
    protected $item;

    /**
     * @param LocatorInterface $locator
     * @param ScopeConfigInterface $scopeConfig
     * @param DigitalLicenseInterface $item
     */
    public function __construct(
        Escaper $escaper,
        LocatorInterface $locator,
        ScopeConfigInterface $scopeConfig,
        DigitalLicenseInterface $item
    ) {
        $this->locator = $locator;
        $this->scopeConfig = $scopeConfig;
        $this->item = $item;
    }

    /**
     * Retrieve default links title
     *
     * @return string
     */
    public function getLicenseText()
    {
        return $this->item->getLicenseText();
        /*
        return $this->locator->getProduct()->getId() &&
        $this->locator->getProduct()->getTypeId() == Type::TYPE_DIGITAL_LICENSE
            ? $this->locator->getProduct()->getBscDigitalLicense()
            : $this->scopeConfig->getValue(
                \Magento\Downloadable\Model\Link::XML_PATH_LINKS_TITLE,
                \Magento\Framework\App\ScopeInterface::SCOPE_DEFAULT
            );
        */
    }

    /**
     * Get Links data
     *
     * @SuppressWarnings(PHPMD.NPathComplexity)
     * @return array
     */
    public function getLicenseData()
    {
        return [];
        $linksData = [];
        if ($this->locator->getProduct()->getTypeId() !== Type::TYPE_DIGITAL_LICENSE) {
            return $linksData;
        }

        $links = $this->locator->getProduct()->getTypeInstance()->getLinks($this->locator->getProduct());
        /** @var LinkInterface $link */
        foreach ($links as $link) {
            $linkData = [];
            $linkData['entity_id'] = $link->getEntityId();
            $linkData['license_text'] = $link->getLicenseText();
            $linkData['sort_order'] = $link->getSortOrder();
            $linksData[] = $linkData;
        }

        return $linksData;
    }
}
