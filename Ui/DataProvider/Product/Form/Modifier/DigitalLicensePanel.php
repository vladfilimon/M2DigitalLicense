<?php
namespace Blockscape\DigitalLicense\Ui\DataProvider\Product\Form\Modifier;

use Magento\Catalog\Ui\DataProvider\Product\Form\Modifier\AbstractModifier;
use Magento\Catalog\Model\Locator\LocatorInterface;
use Magento\Framework\Stdlib\ArrayManager;
use Magento\Ui\Component\Container;
use Magento\Ui\Component\Form;
use \Magento\Catalog\Api\Data\ProductAttributeInterface;

/**
 * Class adds Downloadable collapsible panel
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class DigitalLicensePanel extends AbstractModifier
{
    /**
     * @var LocatorInterface
     */
    protected $locator;

    /**
     * @var ArrayManager
     */
    protected $arrayManager;

    /**
     * @var array
     */
    protected $meta = [];

    /**
     * @param LocatorInterface $locator
     * @param ArrayManager $arrayManager
     */
    public function __construct(LocatorInterface $locator, ArrayManager $arrayManager)
    {
        $this->locator = $locator;
        $this->arrayManager = $arrayManager;
    }

    /**
     * {@inheritdoc}
     */
    public function modifyData(array $data)
    {
        $model = $this->locator->getProduct();


        $data[$model->getId()]['has_digital_licenses'] =
            sizeof($this->locator->getProduct()->getExtensionAttributes()->getDigitalLicenses()) ?  '1' : '0';

        return $data;
    }

    /**
     * {@inheritdoc}
     */
    public function modifyMeta(array $meta)
    {
        $this->meta = $meta;

        $panelConfig['arguments']['data']['config'] = [
            'componentType' => Form\Fieldset::NAME,
            'label' => __('Blockscape Digital License'),
            'collapsible' => true,
            'opened' => sizeof($this->locator->getProduct()->getExtensionAttributes()->getDigitalLicenses()) ? true : false,
            'sortOrder' => '800',
            'dataScope' => 'data'
        ];
        $this->meta = $this->arrayManager->set('digital_license', $this->meta, $panelConfig);

        $this->addCheckboxIsDigitalLicense();
        $this->addMessageBox();

        return $this->meta;
    }

    /**
     * Add message
     *
     * @return void
     */
    protected function addMessageBox()
    {
        $messagePath = 'digital_license/children/advice_message';
        $messageConfig['arguments']['data']['config'] = [
            'componentType' => Container::NAME,
            'component' => 'Magento_Ui/js/form/components/html',
            'additionalClasses' => 'admin__fieldset-note',
            'content' => __('To enable the option set the weight to no'),
            'sortOrder' => 20,
            'visible' => false,
            'imports' => [
                'visible' => '${$.provider}:' . self::DATA_SCOPE_PRODUCT . '.'
                    . ProductAttributeInterface::CODE_HAS_WEIGHT
            ],
        ];

        $this->meta = $this->arrayManager->set($messagePath, $this->meta, $messageConfig);
    }

    /**
     * Add Checkbox
     *
     * @return void
     */
    protected function addCheckboxIsDigitalLicense()
    {
        $checkboxPath = 'digital_license/children/has_digital_licenses';
        $checkboxConfig['arguments']['data']['config'] = [
            'dataType' => Form\Element\DataType\Number::NAME,
            'formElement' => Form\Element\Checkbox::NAME,
            'componentType' => Form\Field::NAME,
            'component' => 'Blockscape_DigitalLicense/js/components/is-digital-license-handler',
            'description' => __('Is this a digital license Product?'),
            'dataScope' => 'has_digital_licenses',
            'sortOrder' => 10,
            'imports' => [
                'disabled' => '${$.provider}:' . self::DATA_SCOPE_PRODUCT . '.has_digital_licenses'
            ],
            'valueMap' => [
                'false' => '0',
                'true' => '1',
            ],
            'licensesFieldset' => 'ns = ${ $.ns }, index=container_licenses'
        ];

        $this->meta = $this->arrayManager->set($checkboxPath, $this->meta, $checkboxConfig);
    }
}
