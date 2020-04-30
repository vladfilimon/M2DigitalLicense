<?php
/**
 * @category Blockscape
 * @package Blockscape_DigitalLicense
 * @author Vlad Filimon Nastase <vlad_filimon@protonmail.com>
 * @copyright Copyright (c) 2020 Blockscape
 */


namespace Blockscape\DigitalLicense\Model;

use \Magento\Framework\Api\SearchCriteriaBuilder;
use \Magento\Catalog\Api\Data\ProductInterface;

/**
 * DigitalLicenseRepository Class
 */
class DigitalLicenseRepository implements \Blockscape\DigitalLicense\Api\DigitalLicenseRepositoryInterface
{

    protected $modelFactory = null;

    protected $collectionFactory = null;

    protected $searchCriteriaBuilder = null;

    /**
     * initialize
     *
     * @param \Blockscape\DigitalLicense\Model\DigitalLicenseFactory $modelFactory
     * @param \Blockscape\DigitalLicense\Model\ResourceModel\DigitalLicense\CollectionFactory $collectionFactory
     * @paramSearchCriteriaBuilder
     * @return void
     */
    public function __construct(
        \Blockscape\DigitalLicense\Model\DigitalLicenseFactory $modelFactory,
        \Blockscape\DigitalLicense\Model\ResourceModel\DigitalLicense\CollectionFactory $collectionFactory,
        SearchCriteriaBuilder $searchCriteriaBuilder
    )
    {
        $this->modelFactory = $modelFactory; 
        $this->collectionFactory = $collectionFactory;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;

    }

    /**
     * get by id
     *
     * @param int $id
     * @return \Blockscape\DigitalLicense\Api\Data\DigitalLicenseInterface
     */
    public function getById($id)
    {
        $model = $this->modelFactory->create()->load($id);
        if (!$model->getId()) { 
         throw new \Magento\Framework\Exception\NoSuchEntityException(__('License with id "%1" ID doesn\'t exist.', $id));
         } 
        return $model;
    }

    /**
     * get by id
     *
     * @param int $id
     * @return \Blockscape\DigitalLicense\Api\Data\DigitalLicenseInterface
     */
    public function save(\Blockscape\DigitalLicense\Api\Data\DigitalLicenseInterface $subject)
    {
        try { 
         $subject->save(); 
        } catch (\Exception $exception) { 
            throw new \Magento\Framework\Exception\CouldNotSaveException(__($exception->getMessage()));
        } 
         return $subject;
    }

    /**
     * get list
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $creteria
     * @return \Magento\Framework\Api\SearchResults
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $creteria)
    {
        $collection = $this->collectionFactory->create(); 
        return $collection;
    }

    /**
     * delete
     *
     * @param \Blockscape\DigitalLicense\Api\Data\DigitalLicenseInterface
     * @return boolean
     */
    public function delete(\Blockscape\DigitalLicense\Api\Data\DigitalLicenseInterface $subject)
    {
        try { 
            $subject->delete();
        } catch (\Exception $exception) {
            throw new \Magento\Framework\Exception\CouldNotDeleteException(__($exception->getMessage()));
        }
        return true;
    }

    /**
     * delete by id
     *
     * @param int $id
     * @return boolean
     */
    public function deleteById($id)
    {
        return $this->delete($this->getById($id));
    }

    /**
     * @param ProductInterface $product
     * @return \Magento\Framework\Api\SearchResults
     */
    public function getByProduct(ProductInterface $product)
    {
        return $this->getList(
            $this->searchCriteriaBuilder
                ->addFilter('product_id', $product->getId())
                ->create()
        );
    }
}
