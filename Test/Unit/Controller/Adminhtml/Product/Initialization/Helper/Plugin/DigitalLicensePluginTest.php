<?php
namespace Blockscape\DigitalLicense\Test\Unit\Controller\Adminhtml\Product\Initialization\Helper\Plugin;

use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use PHPUnit\Framework\TestCase;
use PHPUnit_Framework_MockObject_MockObject;

/**
 * @covers \Blockscape\DigitalLicense\Controller\Adminhtml\Product\Initialization\Helper\Plugin\DigitalLicensePlugin
 */
class DigitalLicensePluginTest extends TestCase
{
    /**
     * Mock productExtensionFactoryInstance
     *
     * @var \Magento\Catalog\Api\Data\ProductExtensionInterface|PHPUnit_Framework_MockObject_MockObject
     */
    private $productExtensionFactoryInstance;

    /**
     * Mock productExtensionFactory
     *
     * @var \Magento\Catalog\Api\Data\ProductExtensionInterfaceFactory|PHPUnit_Framework_MockObject_MockObject
     */
    private $productExtensionFactory;

    /**
     * Mock digitalLicenseFactoryInstance
     *
     * @var \Blockscape\DigitalLicense\Model\DigitalLicense|PHPUnit_Framework_MockObject_MockObject
     */
    private $digitalLicenseFactoryInstance;

    /**
     * Mock digitalLicenseFactory
     *
     * @var \Blockscape\DigitalLicense\Model\DigitalLicenseFactory|PHPUnit_Framework_MockObject_MockObject
     */
    private $digitalLicenseFactory;

    /**
     * Mock digitalLicenseRepository
     *
     * @var \Blockscape\DigitalLicense\Api\DigitalLicenseRepositoryInterface|PHPUnit_Framework_MockObject_MockObject
     */
    private $digitalLicenseRepository;

    /**
     * Object Manager instance
     *
     * @var \Magento\Framework\ObjectManagerInterface
     */
    private $objectManager;

    /**
     * Object to test
     *
     * @var \Blockscape\DigitalLicense\Controller\Adminhtml\Product\Initialization\Helper\Plugin\DigitalLicensePlugin
     */
    private $testObject;

    /**
     * Main set up method
     */
    public function setUp()
    {
        $this->objectManager = new ObjectManager($this);
        $this->productExtensionFactoryInstance = $this->createMock(\Magento\Catalog\Api\Data\ProductExtensionInterface::class);
        $this->productExtensionFactory = $this->createMock(\Magento\Catalog\Api\Data\ProductExtensionInterfaceFactory::class);
        $this->productExtensionFactory->method('create')->willReturn($this->productExtensionFactoryInstance);
        $this->digitalLicenseFactoryInstance = $this->createMock(\Blockscape\DigitalLicense\Model\DigitalLicense::class);
        $this->digitalLicenseFactory = $this->createMock(\Blockscape\DigitalLicense\Model\DigitalLicenseFactory::class);
        $this->digitalLicenseFactory->method('create')->willReturn($this->digitalLicenseFactoryInstance);
        $this->digitalLicenseRepository = $this->createMock(\Blockscape\DigitalLicense\Model\DigitalLicenseRepository::class);
        $this->testObject = $this->objectManager->getObject(
        \Blockscape\DigitalLicense\Controller\Adminhtml\Product\Initialization\Helper\Plugin\DigitalLicensePlugin::class,
            [
                'productExtensionFactory' => $this->productExtensionFactory,
                'digitalLicenseFactory' => $this->digitalLicenseFactory,
                'digitalLicenseRepository' => $this->digitalLicenseRepository,
            ]
        );
    }

    /**
     * @return array
     */
    public function dataProviderForTestAfterGet()
    {
        return [
            'Testcase 1' => [
                'prerequisites' => ['param' => 1],
                'expectedResult' => ['param' => 1]
            ]
        ];
    }

    /**
     * @dataProvider dataProviderForTestAfterGet
     */
    public function testAfterGet(array $prerequisites, array $expectedResult)
    {
        $this->assertEquals($expectedResult['param'], $prerequisites['param']);
    }

    /**
     * @return array
     */
    public function dataProviderForTestAfterGetList()
    {
        return [
            'Testcase 1' => [
                'prerequisites' => ['param' => 1],
                'expectedResult' => ['param' => 1]
            ]
        ];
    }

    /**
     * @dataProvider dataProviderForTestAfterGetList
     */
    public function testAfterGetList(array $prerequisites, array $expectedResult)
    {
        $this->assertEquals($expectedResult['param'], $prerequisites['param']);
    }

    /**
     * @return array
     */
    public function dataProviderForTestAfterSave()
    {
        return [
            'Testcase 1' => [
                'prerequisites' => ['param' => 1],
                'expectedResult' => ['param' => 1]
            ]
        ];
    }

    /**
     * @dataProvider dataProviderForTestAfterSave
     */
    public function testAfterSave(array $prerequisites, array $expectedResult)
    {
        $this->assertEquals($expectedResult['param'], $prerequisites['param']);
    }
}
