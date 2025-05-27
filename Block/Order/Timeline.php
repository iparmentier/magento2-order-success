<?php
/**
 * Copyright © Amadeco. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Amadeco\OrderSuccess\Block\Order;

use Magento\Framework\Stdlib\DateTime\DateTime;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Sales\Model\Order;
use Magento\Sales\Model\Order\Config as OrderConfig;
use Magento\Sales\Model\ResourceModel\Order\Status\History\CollectionFactory as HistoryCollectionFactory;
use Amadeco\OrderSuccess\Helper\Data as Helper;

/**
 * Order timeline block
 *
 * @api
 */
class Timeline extends Template
{
    /**
     * @var DateTime
     */
    private DateTime $dateTime;

    /**
     * @var Helper
     */
    private Helper $helper;

    /**
     * @var OrderConfig
     */
    private OrderConfig $orderConfig;

    /**
     * @var HistoryCollectionFactory
     */
    private HistoryCollectionFactory $historyCollectionFactory;

    /**
     * @param Context $context
     * @param DateTime $dateTime
     * @param Helper $helper
     * @param OrderConfig $orderConfig
     * @param HistoryCollectionFactory $historyCollectionFactory
     * @param array $data
     */
    public function __construct(
        Context $context,
        DateTime $dateTime,
        Helper $helper,
        OrderConfig $orderConfig,
        HistoryCollectionFactory $historyCollectionFactory,
        array $data = []
    ) {
        $this->dateTime = $dateTime;
        $this->helper = $helper;
        $this->orderConfig = $orderConfig;
        $this->historyCollectionFactory = $historyCollectionFactory;
        parent::__construct($context, $data);
    }

    /**
     * Check if timeline should be shown
     *
     * @return bool
     */
    public function canShowTimeline(): bool
    {
        return $this->helper->isTimelineEnabled();
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
     * Get timeline steps based on order status flow
     *
     * @return array
     */
    public function getTimelineSteps(): array
    {
        $order = $this->getOrder();
        if (!$order) {
            return [];
        }

        $currentStatus = $order->getStatus();
        $steps = [];

        // Define standard e-commerce flow with Magento statuses
        $standardFlow = [
            [
                'code' => 'pending',
                'title' => __('Order Placed'),
                'statuses' => [
                    Order::STATE_NEW,
                    Order::STATE_HOLDED,
                    Order::STATE_PENDING_PAYMENT,
                    Order::STATE_PAYMENT_REVIEW
                ],
                'icon' => 'cart'
            ],
            [
                'code' => 'payment',
                'title' => __('Confirmed Payment'),
                'statuses' => [
                    Order::STATE_PROCESSING
                ],
                'icon' => 'payment'
            ],
            [
                'code' => 'processing',
                'title' => __('Processing'),
                'statuses' => [
                    Order::STATE_PROCESSING
                ],
                'icon' => 'settings'
            ],
            [
                'code' => 'complete',
                'title' => __('Sent'),
                'statuses' => [
                    Order::STATE_COMPLETE,
                    Order::STATE_CLOSED
                ],
                'icon' => 'truck'
            ]
        ];

        // Get order history
        $history = $this->getOrderHistory();

        // Determine current step and completed steps
        $currentStepIndex = $this->getCurrentStepIndex($currentStatus, $standardFlow);

        foreach ($standardFlow as $index => $step) {
            $isComplete = $index < $currentStepIndex;
            $isActive = $index === $currentStepIndex;
            $isPending = $index > $currentStepIndex;

            $stepData = [
                'code' => $step['code'],
                'title' => $step['title'],
                'icon' => $step['icon'],
                'is_complete' => $isComplete,
                'is_active' => $isActive,
                'is_pending' => $isPending
            ];

            $steps[] = $stepData;
        }

        return $steps;
    }

    /**
     * Get order status history
     *
     * @return array
     */
    private function getOrderHistory(): array
    {
        $order = $this->getOrder();
        if (!$order) {
            return [];
        }

        $collection = $this->historyCollectionFactory->create()
            ->addFieldToFilter('parent_id', $order->getId())
            ->setOrder('created_at', 'ASC');

        $history = [];
        foreach ($collection as $item) {
            $history[$item->getStatus()] = $item->getCreatedAt();
        }

        return $history;
    }

    /**
     * Get current step index based on status
     *
     * @param string $currentStatus
     * @param array $flow
     * @return int
     */
    private function getCurrentStepIndex(string $currentStatus, array $flow): int
    {
        foreach ($flow as $index => $step) {
            if (in_array($currentStatus, $step['statuses'])) {
                return $index;
            }
        }

        // Default to first step if status not found
        return 0;
    }

    /**
     * Get CSS class for step item
     *
     * @param array $step
     * @return string
     */
    public function getStepCssClass(array $step): string
    {
        $classes = ['opc-progress-bar-item'];

        if ($step['is_complete']) {
            $classes[] = '_complete';
        } elseif ($step['is_active']) {
            $classes[] = '_active';
        }

        if (isset($step['is_canceled']) && $step['is_canceled']) {
            $classes[] = '_error';
        }

        return implode(' ', $classes);
    }

    /**
     * Get CSS class for step span
     *
     * @param array $step
     * @return string
     */
    public function getStepSpanCssClass(array $step): string
    {
        return 'opc-progress-bar-item-' . $step['code'];
    }
}