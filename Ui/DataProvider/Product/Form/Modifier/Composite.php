<?php
namespace Blockscape\DigitalLicense\Ui\DataProvider\Product\Form\Modifier;

use Magento\Catalog\Ui\DataProvider\Product\Form\Modifier\AbstractModifier;
use Magento\Catalog\Model\Locator\LocatorInterface;
use Magento\Downloadable\Model\Product\Type as DownloadableType;
use Magento\Catalog\Model\Product\Type as CatalogType;
use Magento\Ui\DataProvider\Modifier\ModifierInterface;
use Magento\Ui\DataProvider\Modifier\ModifierFactory;
use Blockscape\DigitalLicense\Model\Product\Type as DigitalDownloadType;

/**
 * Customize Downloadable panel
 */
class Composite extends AbstractModifier
{

    const CHILDREN_PATH = 'digital_license/children';
    const CONTAINER_LINKS = 'container_digital_license_key';

    /**
     * @var ModifierFactory
     */
    protected $modifierFactory;

    /**
     * @var array
     */
    protected $modifiers = [];

    /**
     * @var ModifierInterface[]
     */
    protected $modifiersInstances = [];

    /**
     * @var LocatorInterface
     */
    protected $locator;

    /**
     * @param ModifierFactory $modifierFactory
     * @param LocatorInterface $locator
     * @param array $modifiers
     */
    public function __construct(
        ModifierFactory $modifierFactory,
        LocatorInterface $locator,
        array $modifiers = []
    ) {
        $this->modifierFactory = $modifierFactory;
        $this->locator = $locator;
        $this->modifiers = $modifiers;
    }

    /**
     * {@inheritdoc}
     */
    public function modifyData(array $data)
    {
        if ($this->canShowPanel()) {
            foreach ($this->getModifiers() as $modifier) {
                $data = $modifier->modifyData($data);
            }
        }
        return $data;
    }

    /**
     * @inheritdoc
     */
    public function modifyMeta(array $meta)
    {
        if ($this->canShowPanel()) {
            foreach ($this->getModifiers() as $modifier) {
                $meta = $modifier->modifyMeta($meta);
            }
        }
        return $meta;
    }

    /**
     * Check that can show downloadable panel
     *
     * @return bool
     */
    protected function canShowPanel()
    {
        $productTypes = [
            DownloadableType::TYPE_DOWNLOADABLE,
            CatalogType::TYPE_SIMPLE,
            CatalogType::TYPE_VIRTUAL
        ];
        return in_array($this->locator->getProduct()->getTypeId(), $productTypes);
    }

    /**
     * Get modifiers list
     *
     * @return ModifierInterface[]
     */
    protected function getModifiers()
    {
        if (empty($this->modifiersInstances)) {
            foreach ($this->modifiers as $modifierClass) {
                $this->modifiersInstances[$modifierClass] = $this->modifierFactory->create($modifierClass);
            }
        }
        return $this->modifiersInstances;
    }
}
