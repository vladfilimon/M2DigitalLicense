<?php

namespace Blockscape\DigitalLicense\Ui\DataProvider\Product\Form\Modifier;

use Magento\Catalog\Ui\DataProvider\Product\Form\Modifier\AbstractModifier;
use Magento\Catalog\Model\Locator\LocatorInterface;
use Blockscape\DigitalLicense\Model\Product\Type;
use Blockscape\DigitalLicense\Api\DigitalLicenseRepositoryInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\Stdlib\ArrayManager;
use Magento\Ui\Component\DynamicRows;
use Magento\Ui\Component\Container;
use Magento\Ui\Component\Form;
use Magento\Framework\Api\SearchCriteriaBuilder;

/**
 * Class adds a grid with links
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class LicenseKeys extends AbstractModifier
{
    /**
     * @var LocatorInterface
     */
    protected $locator;

    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var ArrayManager
     */
    protected $arrayManager;

    /**
     * @var Data\LicenseKeys
     */
    protected $linksData;

    protected $licenseRepository;
    protected $scb;

    /**
     * @param LocatorInterface $locator
     * @param StoreManagerInterface $storeManager
     * @param ArrayManager $arrayManager
     * @param Data\LicenseKeys $linksData
     * @param DigitalLicenseRepositoryInterface $licenseRepository
     * @param SearchCriteriaBuilder $search_criteria
     */
    public function __construct(
        LocatorInterface $locator,
        StoreManagerInterface $storeManager,
        ArrayManager $arrayManager,
        Data\LicenseKeys $linksData,
        DigitalLicenseRepositoryInterface $licenseRepository,
        SearchCriteriaBuilder $scb
    ) {
        $this->locator = $locator;
        $this->storeManager = $storeManager;
        $this->arrayManager = $arrayManager;
        $this->linksData = $linksData;
        $this->licenseRepository =  $licenseRepository;
        $this->scb = $scb;
    }



    /**
     * {@inheritdoc}
     */
    public function modifyData(array $data)
    {
        $licensesArray = [];
        foreach ($this->locator->getProduct()->getExtensionAttributes()->getDigitalLicenses() as $license) {
            $licensesArray[] = $license->getData();
        }
        $data[$this->locator->getProduct()->getId()]['digital_license']['licenses'] = $licensesArray;
        return $data;

    }

    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function modifyMeta(array $meta)
    {
        /*
  'digital_license' =>
    array (size=2)
      'arguments' =>
        array (size=1)
          'data' =>
            array (size=1)
              ...
      'children' =>
        array (size=2)
          'is_digital_license' =>
            array (size=1)
              ...
          'downloadable_message' =>
            array (size=1)
              ...
         */

        //$linksPath = Composite::CHILDREN_PATH . '/' . Composite::CONTAINER_LINKS;
        $linksPath = 'digital_license/children/container_licenses';

        $linksContainer['arguments']['data']['config'] = [
            'componentType' => Form\Fieldset::NAME,
            'additionalClasses' => 'admin__fieldset-section',
            'label' => __('License Keys'),
            'dataScope' => '',
            'visible' => 1,//$this->locator->getProduct()->getTypeId() === Type::TYPE_DIGITAL_LICENSE,
            'sortOrder' => 30,
        ];

        /*
        $linksTitle['arguments']['data']['config'] = [
            'componentType' => Form\Field::NAME,
            'formElement' => Form\Element\Input::NAME,
            'dataType' => Form\Element\DataType\Text::NAME,
            'label' => __('License Key'),
            'dataScope' => 'product.digital_license_key',
            'scopeLabel' => $this->storeManager->isSingleStoreMode() ? '' : '[STORE VIEW]',
        ];
        */

        $linksContainer = $this->arrayManager->set(
            'children',
            $linksContainer,
            [
                'licenses' => $this->getDynamicRows(),
            ]
        );

        return $this->arrayManager->set($linksPath, $meta, $linksContainer);
    }

    /**
     * @return array
     */
    protected function getDynamicRows()
    {
        $dynamicRows['arguments']['data']['config'] = [
            'addButtonLabel' => __('Add License Key'),
            'componentType' => DynamicRows::NAME,
            'itemTemplate' => 'record',
            'renderDefaultRecord' => false,
            'columnsHeader' => true,
            'additionalClasses' => 'admin__field-wide',
            'dataScope' => 'digital_license',
            'deleteProperty' => 'is_delete',
            'deleteValue' => '1',
        ];


        return $this->arrayManager->set('children/record', $dynamicRows, $this->getRecord());
    }

    /**
     * @return array
     */
    protected function getRecord()
    {

        $record['arguments']['data']['config'] = [
            'componentType' => Container::NAME,
            'isTemplate' => true,
            'is_collection' => true,
            'component' => 'Magento_Ui/js/dynamic-rows/record',
            'dataScope' => '',
        ];
        $recordPosition['arguments']['data']['config'] = [
            'componentType' => Form\Field::NAME,
            'formElement' => Form\Element\Input::NAME,
            'dataType' => Form\Element\DataType\Number::NAME,
            'dataScope' => 'sort_order',
            'visible' => false,
        ];
        $recordActionDelete['arguments']['data']['config'] = [
            'label' => null,
            'componentType' => 'actionDelete',
            'fit' => true,
        ];

        return $this->arrayManager->set(
            'children',
            $record,
            [
                'container_digital_license' => $this->getLicenseKeyColumn(),
                'position' => $recordPosition,
                'action_delete' => $recordActionDelete,
            ]
        );
    }

    /**
     * @return array
     */
    protected function getLicenseKeyColumn()
    {

        $container['arguments']['data']['config'] = [
            'componentType' => Container::NAME,
            'formElement' => Container::NAME,
            'component' => 'Magento_Ui/js/form/components/group',
            'label' => __('License Key'),
            'showLabel' => false,
            'dataScope' => '',
        ];
        $field['arguments']['data']['config'] = [
            'formElement' => Form\Element\Input::NAME,
            'componentType' => Form\Field::NAME,
            'dataType' => Form\Element\DataType\Text::NAME,
            'dataScope' => 'license_text',
            'validation' => [
                'required-entry' => true,
            ],
        ];

        return $this->arrayManager->set('children/container_digital_license_text', $container, $field);
    }
}
