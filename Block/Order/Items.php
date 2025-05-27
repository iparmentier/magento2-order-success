<?php
/**
 * Copyright © Amadeco. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Amadeco\OrderSuccess\Block\Order;

use Magento\Framework\App\ObjectManager;
use Magento\Framework\Registry;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Sales\Model\Order;
use Magento\Sales\Model\Order\Item;
use Magento\Sales\Model\ResourceModel\Order\Item\Collection;
use Magento\Sales\Model\ResourceModel\Order\Item\CollectionFactory;
use Amadeco\OrderSuccess\Helper\Data as Helper;

/**
 * Order items block
 *
 * @api
 */
class Items extends \Magento\Sales\Block\Order\Items
{
    /**
     * @var Helper
     */
    private Helper $helper;

    /**
     * @var CollectionFactory
     */
    private $itemCollectionFactory;

    /**
     * @param Context $context
     * @param Registry $registry
     * @param Helper $helper
     * @param CollectionFactory|null $itemCollectionFactory
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        Helper $helper,
        array $data = [],
        ?CollectionFactory $itemCollectionFactory = null
    ) {
        $this->helper = $helper;
        $this->itemCollectionFactory = $itemCollectionFactory ?: ObjectManager::getInstance()
            ->get(CollectionFactory::class);
        parent::__construct($context, $registry, $data, $this->itemCollectionFactory);
    }

    /**
     * Check if items should be shown
     *
     * @return bool
     */
    public function canShowItems(): bool
    {
        return $this->helper->isOrderItemsEnabled();
    }

    /**
     * Get order from parent block
     *
     * @return Order|null
     */
    public function getOrder(): ?Order
    {
        return $this->getParentBlock()->getOrder();
    }

    /**
     * Get visible order items
     *
     * @return Item[]
     */
    public function getItems(): array
    {
        $order = $this->getOrder();
        return $order ? parent::getItems() : [];
    }
}