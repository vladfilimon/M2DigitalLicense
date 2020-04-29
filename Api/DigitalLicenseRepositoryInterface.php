<?php
/**
 * @category Blockscape
 * @package Blockscape_DigitalLicense
 * @author Vlad Filimon Nastase <vlad_filimon@protonmail.com>
 * @copyright Copyright (c) 2020 Blockscape
 */


namespace Blockscape\DigitalLicense\Api;

/**
 * Interface
 */
interface DigitalLicenseRepositoryInterface
{

    /**
     * get by id
     *
     * @param int $id
     * @return \Blockscape\DigitalLicense\Model\DigitalLicense
     */
    public function getById($id);
    /**
     * get by id
     *
     * @param int $id
     * @return \Blockscape\DigitalLicense\Model\DigitalLicense
     */
    public function save(\Blockscape\DigitalLicense\Model\DigitalLicense $subject);
    /**
     * get list
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $creteria
     * @return \Magento\Framework\Api\SearchResults
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $creteria);
    /**
     * delete
     *
     * @param \Blockscape\DigitalLicense\Model\DigitalLicense $subject
     * @return boolean
     */
    public function delete(\Blockscape\DigitalLicense\Model\DigitalLicense $subject);
    /**
     * delete by id
     *
     * @param int $id
     * @return boolean
     */
    public function deleteById($id);
    /**
     * @param \Magento\Catalog\Api\Data\ProductInterface $product
     * @return \Magento\Framework\Api\SearchResults
     */
    public function getByProduct(\Magento\Catalog\Api\Data\ProductInterface $product);

}

