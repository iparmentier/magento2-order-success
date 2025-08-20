<?php
/**
 * Copyright © Amadeco. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Amadeco\OrderSuccess\Block\Order;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Checkout\Model\Session as CheckoutSession;
use Magento\Cms\Block\Block;
use Magento\Sales\Model\Order;
use Amadeco\OrderSuccess\Helper\Data as Helper;

/**
 * Order success page main block
 *
 * @api
 */
class Success extends Template
{
    /**
     * @var CheckoutSession
     */
    private CheckoutSession $checkoutSession;

    /**
     * @var \Magento\Framework\App\Http\Context
     */
    protected $httpContext;

    /**
     * @var Helper
     */
    private Helper $helper;

    /**
     * @var Order|null
     */
    private ?Order $order = null;

    /**
     * @param Context $context
     * @param CheckoutSession $checkoutSession
     * @param Helper $helper
     * @param array $data
     */
    public function __construct(
        Context $context,
        CheckoutSession $checkoutSession,
        \Magento\Framework\App\Http\Context $httpContext,
        Helper $helper,
        array $data = []
    ) {
        $this->checkoutSession = $checkoutSession;
        $this->httpContext = $httpContext;
        $this->helper = $helper;
        parent::__construct($context, $data);
    }

    /**
     * Prevent displaying if order is not populated or block is disabled
     *
     * @return string
     */
    protected function _toHtml()
    {
        $order = $this->getOrder();
        if (!$order || !$order->getIncrementId() || !$this->isEnabled()) {
            return '';
        }
        return parent::_toHtml();
    }

    /**
     * Check if module is enabled
     *
     * @return bool
     */
    public function isEnabled(): bool
    {
        return $this->helper->isEnabled();
    }

    /**
     * Get current order
     *
     * @return Order|null
     */
    public function getOrder(): ?Order
    {
        if ($this->order === null) {
            $this->order = $this->checkoutSession->getLastRealOrder();
        }
        return $this->order;
    }

    /**
     * Get continue shopping URL
     *
     * @return string
     */
    public function getContinueUrl(): string
    {
        return $this->getUrl('');
    }

    /**
     * Get print order URL
     *
     * @return string
     */
    public function getPrintUrl(): string
    {
        if (!$this->isCustomerLoggedIn()) {
            return $this->getUrl('sales/guest/print', ['order_id' => $this->getOrder()->getId()]);
        }
        return $this->getUrl('sales/order/print', ['order_id' => $this->getOrder()->getId()]);
    }

    /**
     * Get reorder URL
     *
     * @return string
     */
    public function getReorderUrl(): string
    {
        if (!$this->isCustomerLoggedIn()) {
            return $this->getUrl('sales/guest/reorder', ['order_id' => $this->getOrder()->getId()]);
        }
        return $this->getUrl('sales/order/reorder', ['order_id' => $this->getOrder()->getId()]);
    }

    /**
     * Get view order URL
     *
     * @return string
     */
    public function getViewOrderUrl(): string
    {
        if (!$this->isCustomerLoggedIn()) {
            return $this->getUrl('sales/guest/view', ['order_id' => $this->getOrder()->getId()]);
        }
        return $this->getUrl('sales/order/view', ['order_id' => $this->getOrder()->getId()]);
    }

    /**
     * Check if customer is logged in
     *
     * @return bool
     */
    public function isCustomerLoggedIn(): bool
    {
        return (bool)$this->httpContext->getValue(\Magento\Customer\Model\Context::CONTEXT_AUTH);
    }

    /**
     * Get before text
     *
     * @param string $scope
     * @return null|string
     */
    public function getBeforeTextDetails(): ?string
    {
        return $this->helper->getBeforeTextDetails();
    }

    /**
     * Get after text
     *
     * @param string $scope
     * @return null|string
     */
    public function getAfterTextDetails(): ?string
    {
        return $this->helper->getAfterTextDetails();
    }

    /**
     * Check if CMS block is enabled
     *
     * @param string $scope
     * @return bool
     */
    public function isCmsBlockEnabled(): bool
    {
        return $this->helper->isCmsBlockEnabled();
    }

    /**
     * Get second CMS block identifier
     *
     * @return null|string
     */
    public function getCmsBlockDetails(): ?string
    {
        if (!$this->getData('cms_block_html')) {
            $html = $this->getLayout()->createBlock(
                Block::class
            )->setBlockId(
                $this->helper->getCmsBlockDetails()
            )->toHtml();
            $this->setData('cms_block_html', $html);
        }
        return $this->getData('cms_block_html');
    }

    /**
     * Check if second CMS block is enabled
     *
     * @return bool
     */
    public function isSecondCmsBlockEnabled(): bool
    {
        return $this->helper->isSecondCmsBlockEnabled();
    }

    /**
     * Get second CMS block identifier
     *
     * @return null|string
     */
    public function getSecondCmsBlockDetails(): ?string
    {
        if (!$this->getData('second_cms_block_html')) {
            $html = $this->getLayout()->createBlock(
                Block::class
            )->setBlockId(
                $this->helper->getSecondCmsBlockDetails()
            )->toHtml();
            $this->setData('second_cms_block_html', $html);
        }
        return $this->getData('second_cms_block_html');
    }
}
