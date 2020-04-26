<?php
/**
 * @category Blockscape
 * @package Blockscape_DigitalLicense
 * @author Vlad Filimon Nastase <vlad_filimon@protonmail.com>
 * @copyright Copyright (c) 2020 Blockscape
 */


namespace Blockscape\DigitalLicense\Model\ResourceModel\DigitalLicense;

/**
 * Collection Class
 */
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{

    protected $_idFieldName = 'license_id';

    /**
     * Initialize resource model
     *
     * @return void
     */
    public function _construct()
    {
        $this->_init("Blockscape\DigitalLicense\Model\DigitalLicense", "Blockscape\DigitalLicense\Model\ResourceModel\DigitalLicense");
        $this->_map['fields']['entity_id'] = 'main_table.license_id';
    }


}

