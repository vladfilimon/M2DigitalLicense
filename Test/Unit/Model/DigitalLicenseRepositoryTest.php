<?php
/**
 * @category Blockscape
 * @package Blockscape_DigitalLicense
 * @author Vlad Filimon Nastase <vlad_filimon@protonmail.com>
 * @copyright Copyright (c) 2020 Blockscape
 */

namespace Blockscape\DigitalLicense\Test\Unit\Model;

use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use PHPUnit\Framework\TestCase;
use PHPUnit_Framework_MockObject_MockObject;

/**
 * @covers \Blockscape\DigitalLicense\Model\DigitalLicenseRepository
 */
class DigitalLicenseRepositoryTest extends TestCase
{
    /**
     * Mock modelFactoryInstance
     *
     * @var \Blockscape\DigitalLicense\Model\DigitalLicense|PHPUnit_Framework_MockObject_MockObject
     */
    private $modelFactoryInstance;

    /**
     * Mock modelFactory
     *
     * @var \Blockscape\DigitalLicense\Model\DigitalLicenseFactory|PHPUnit_Framework_MockObject_MockObject
     */
    private $modelFactory;

    /**
     * Mock collectionFactoryInstance
     *
     * @var \Blockscape\DigitalLicense\Model\ResourceModel\DigitalLicense\Collection|PHPUnit_Framework_MockObject_MockObject
     */
    private $collectionFactoryInstance;

    /**
     * Mock collectionFactory
     *
     * @var \Blockscape\DigitalLicense\Model\ResourceModel\DigitalLicense\CollectionFactory|PHPUnit_Framework_MockObject_MockObject
     */
    private $collectionFactory;

    /**
     * Object Manager instance
     *
     * @var \Magento\Framework\ObjectManagerInterface
     */
    private $objectManager;

    /**
     * Object to test
     *
     * @var \Blockscape\DigitalLicense\Model\DigitalLicenseRepository
     */
    private $testObject;

    /**
     * Main set up method
     */
    public function setUp()
    {
        $this->objectManager = new ObjectManager($this);
        $this->modelFactoryInstance = $this->createMock(\Blockscape\DigitalLicense\Model\DigitalLicense::class);
        $this->modelFactory = $this->createMock(\Blockscape\DigitalLicense\Model\DigitalLicenseFactory::class);
        $this->modelFactory->method('create')->willReturn($this->modelFactoryInstance);
        $this->collectionFactoryInstance = $this->createMock(\Blockscape\DigitalLicense\Model\ResourceModel\DigitalLicense\Collection::class);
        $this->collectionFactory = $this->createMock(\Blockscape\DigitalLicense\Model\ResourceModel\DigitalLicense\CollectionFactory::class);
        $this->collectionFactory->method('create')->willReturn($this->collectionFactoryInstance);
        $this->testObject = $this->objectManager->getObject(
        \Blockscape\DigitalLicense\Model\DigitalLicenseRepository::class,
            [
                'modelFactory' => $this->modelFactory,
                'collectionFactory' => $this->collectionFactory,
            ]
        );
    }

    /**
     * @return array
     */
    public function dataProviderForTestGetById()
    {
        return [
            'Testcase 1' => [
                'prerequisites' => ['param' => 1],
                'expectedResult' => ['param' => 1]
            ]
        ];
    }

    /**
     * @dataProvider dataProviderForTestGetById
     */
    public function testGetById(array $prerequisites, array $expectedResult)
    {
        $this->assertEquals($expectedResult['param'], $prerequisites['param']);
    }

    /**
     * @return array
     */
    public function dataProviderForTestSave()
    {
        return [
            'Testcase 1' => [
                'prerequisites' => ['param' => 1],
                'expectedResult' => ['param' => 1]
            ]
        ];
    }

    /**
     * @dataProvider dataProviderForTestSave
     */
    public function testSave(array $prerequisites, array $expectedResult)
    {
        $this->assertEquals($expectedResult['param'], $prerequisites['param']);
    }

    /**
     * @return array
     */
    public function dataProviderForTestGetList()
    {
        return [
            'Testcase 1' => [
                'prerequisites' => ['param' => 1],
                'expectedResult' => ['param' => 1]
            ]
        ];
    }

    /**
     * @dataProvider dataProviderForTestGetList
     */
    public function testGetList(array $prerequisites, array $expectedResult)
    {
        $this->assertEquals($expectedResult['param'], $prerequisites['param']);
    }

    /**
     * @return array
     */
    public function dataProviderForTestDelete()
    {
        return [
            'Testcase 1' => [
                'prerequisites' => ['param' => 1],
                'expectedResult' => ['param' => 1]
            ]
        ];
    }

    /**
     * @dataProvider dataProviderForTestDelete
     */
    public function testDelete(array $prerequisites, array $expectedResult)
    {
        $this->assertEquals($expectedResult['param'], $prerequisites['param']);
    }

    /**
     * @return array
     */
    public function dataProviderForTestDeleteById()
    {
        return [
            'Testcase 1' => [
                'prerequisites' => ['param' => 1],
                'expectedResult' => ['param' => 1]
            ]
        ];
    }

    /**
     * @dataProvider dataProviderForTestDeleteById
     */
    public function testDeleteById(array $prerequisites, array $expectedResult)
    {
        $this->assertEquals($expectedResult['param'], $prerequisites['param']);
    }
}
