<?php

namespace Boo\CustomAttribute\Setup;

use Magento\Eav\Setup\EavSetup;

use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

use Magento\Eav\Model\Config;

class InstallData implements InstallDataInterface{

    const CUSTOM_ATTRIBUTE_CODE = 'custom';

    /**
     * @var eavSetup
     */
    private $eavSetup;

    /**
     * @var Config
     */
    private $eavConfig;

    /**
     *
     */
    public function __construct(
        EavSetup $EavSetup,
        Config $config)
    {
        $this->startSetup = $EavSetup;
        $this->eavConfig = $config;
    }

    /**
     * @param ModuleDataSetupInterface $setup
     * @param ModuleContextInterface $context
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();
        $this->eavSetup->addAttribute(
            AdressMetadataInterface::ENTITY_TYPE_ADRESS,
            self::CUSTOM_ATTRIBUTE_CODE,
            [
                'label' => 'Custom',
                'input' => 'text',
                'visible' => true,
                'required' => false,
                'position' => 150,
                'sort_order' => 150,
                'system' => false,
                'user_defined' => true
            ]
        );

        $customAttribute = $this->eavConfig->getAttribute(
            AdressMetadataInterface::ENTITY_TYPE_ADRESS,
            self::CUSTOM_ATTRIBUTE_CODE
        );

        $customAttribute->setData(
            'used_in_forms',
            ['adminhtml_customer_adress', 'customer_addres_edit', 'customer_register_adress']
        );

        $customAttribute->save();

        $setup->endSetup();
    }
}