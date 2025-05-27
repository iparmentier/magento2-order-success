<?php
/**
 * Copyright © Amadeco. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Amadeco\OrderSuccess\Block\Order;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Sales\Model\Order;
use Magento\Payment\Helper\Data as PaymentHelper;
use Magento\Sales\Model\Order\Address\Renderer;
use Amadeco\OrderSuccess\Helper\Data as Helper;

/**
 * Order information block
 *
 * @api
 */
class Info extends Template
{
    /**
     * @var \Magento\Payment\Helper\Data
     */
    private PaymentHelper $paymentHelper;

    /**
     * @var Renderer
     */
    private Renderer $addressRenderer;

    /**
     * @var Helper
     */
    private Helper $helper;

    /**
     * @param Context $context
     * @param PaymentHelper $paymentHelper
     * @param Renderer $addressRenderer
     * @param Helper $helper
     * @param array $data
     */
    public function __construct(
        Context $context,
        PaymentHelper $paymentHelper,
        Renderer $addressRenderer,
        Helper $helper,
        array $data = []
    ) {
        $this->addressRenderer = $addressRenderer;
        $this->paymentHelper = $paymentHelper;
        $this->helper = $helper;
        parent::__construct($context, $data);
    }

    /**
     * Prepare Layout
     *
     * @return void
     */
    protected function _prepareLayout()
    {
        $infoBlock = $this->paymentHelper->getInfoBlock($this->getOrder()->getPayment(), $this->getLayout());
        $this->setChild('payment_info', $infoBlock);
    }

    /**
     * Get payment info html
     *
     * @return string
     */
    public function getPaymentInfoHtml()
    {
        return $this->getChildHtml('payment_info');
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
     * Check if shipping address should be shown
     *
     * @return bool
     */
    public function canShowShippingAddress(): bool
    {
        return $this->helper->isShippingAddressEnabled() && !$this->getOrder()->getIsVirtual();
    }

    /**
     * Format shipping address
     *
     * @return string
     */
    public function getFormattedShippingAddress(): string
    {
        $order = $this->getOrder();
        if (!$order || $order->getIsVirtual()) {
            return '';
        }

        $shippingAddress = $order->getShippingAddress();
        return $shippingAddress ? $this->addressRenderer->format($shippingAddress, 'html') : '';
    }

    /**
     * Check if billing address should be shown
     *
     * @return bool
     */
    public function canShowBillingAddress(): bool
    {
        return $this->helper->isBillingAddressEnabled();
    }

    /**
     * Format billing address
     *
     * @return string
     */
    public function getFormattedBillingAddress(): string
    {
        $order = $this->getOrder();
        if (!$order) {
            return '';
        }

        $billingAddress = $order->getBillingAddress();
        return $billingAddress ? $this->addressRenderer->format($billingAddress, 'html') : '';
    }

    /**
     * Check if shipping method should be shown
     *
     * @return bool
     */
    public function canShowShippingMethod(): bool
    {
        return $this->helper->isShippingMethodEnabled() && !$this->getOrder()->getIsVirtual();
    }

    /**
     * Get shipping method
     *
     * @return string
     */
    public function getShippingMethod(): string
    {
        $order = $this->getOrder();
        return $order && !$order->getIsVirtual() ? (string)$order->getShippingDescription() : '';
    }

    /**
     * Check if payment method should be shown
     *
     * @return bool
     */
    public function canShowPaymentMethod(): bool
    {
        return $this->helper->isPaymentMethodEnabled();
    }

    /**
     * Get payment method
     *
     * @return string
     */
    public function getPaymentMethod(): string
    {
        $order = $this->getOrder();
        if (!$order) {
            return '';
        }

        $payment = $order->getPayment();
        if ($payment && $payment->getMethodInstance()) {
            return (string)$payment->getMethodInstance()->getTitle();
        }

        return '';
    }
}