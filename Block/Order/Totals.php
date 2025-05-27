<?php
/**
 * Copyright © Amadeco. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Amadeco\OrderSuccess\Block\Order;

use Magento\Framework\DataObject;
use Magento\Framework\View\Element\Template;
use Magento\Sales\Model\Order;

/**
 * Order totals block
 *
 * @api
 */
class Totals extends \Magento\Sales\Block\Order\Totals
{
    /**
     * Get order from parent block
     *
     * @return Order|null
     */
    public function getOrder(): ?Order
    {
        if (!$this->hasData('order')) {
            $this->setData('order', $this->getParentBlock()->getOrder());
        }
        return $this->getData('order');
    }
}