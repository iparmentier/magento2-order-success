<?php
/**
 * Copyright © Amadeco. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Amadeco\OrderSuccess\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;

/**
 * Order success helper
 *
 * @api
 */
class Data extends AbstractHelper
{
    /**
     * XML Configuration Paths
     */
    private const XML_PATH_ENABLED = 'amadeco_order_success/general/enabled';
    private const XML_PATH_SHOW_ORDER_ITEMS = 'amadeco_order_success/general/show_order_items';
    private const XML_PATH_SHOW_SHIPPING_ADDRESS = 'amadeco_order_success/general/show_shipping_address';
    private const XML_PATH_SHOW_BILLING_ADDRESS = 'amadeco_order_success/general/show_billing_address';
    private const XML_PATH_SHOW_SHIPPING_METHOD = 'amadeco_order_success/general/show_shipping_method';
    private const XML_PATH_SHOW_PAYMENT_METHOD = 'amadeco_order_success/general/show_payment_method';
    private const XML_PATH_SHOW_TIMELINE = 'amadeco_order_success/general/show_timeline';

    private const XML_PATH_TEXT_BEFORE = 'amadeco_order_success/before_config/text_before';
    private const XML_PATH_TEXT_AFTER = 'amadeco_order_success/after_config/text_after';
    private const XML_PATH_ENABLE_CMS_BLOCK = 'amadeco_order_success/custom_block_config/enable_cms_block';
    private const XML_PATH_CMS_BLOCK ='amadeco_order_success/custom_block_config/cms_block';
    private const XML_PATH_ENABLE_CMS_BLOCK_2 = 'amadeco_order_success/custom_block_config/enable_cms_block_2';
    private const XML_PATH_CMS_BLOCK_2 ='amadeco_order_success/custom_block_config/cms_block_2';

    /**
     * Check if module is enabled
     *
     * @param string $scope
     * @return bool
     */
    public function isEnabled($scope = ScopeInterface::SCOPE_STORE): bool
    {
        return $this->scopeConfig->isSetFlag(self::XML_PATH_ENABLED, $scope);
    }

    /**
     * Check if order items display is enabled
     *
     * @param string $scope
     * @return bool
     */
    public function isOrderItemsEnabled($scope = ScopeInterface::SCOPE_STORE): bool
    {
        return $this->scopeConfig->isSetFlag(self::XML_PATH_SHOW_ORDER_ITEMS, $scope);
    }

    /**
     * Check if shipping address display is enabled
     *
     * @param string $scope
     * @return bool
     */
    public function isShippingAddressEnabled($scope = ScopeInterface::SCOPE_STORE): bool
    {
        return $this->scopeConfig->isSetFlag(self::XML_PATH_SHOW_SHIPPING_ADDRESS, $scope);
    }

    /**
     * Check if billing address display is enabled
     *
     * @param string $scope
     * @return bool
     */
    public function isBillingAddressEnabled($scope = ScopeInterface::SCOPE_STORE): bool
    {
        return $this->scopeConfig->isSetFlag(self::XML_PATH_SHOW_BILLING_ADDRESS, $scope);
    }

    /**
     * Check if shipping method display is enabled
     *
     * @param string $scope
     * @return bool
     */
    public function isShippingMethodEnabled($scope = ScopeInterface::SCOPE_STORE): bool
    {
        return $this->scopeConfig->isSetFlag(self::XML_PATH_SHOW_SHIPPING_METHOD, $scope);
    }

    /**
     * Check if payment method display is enabled
     *
     * @param string $scope
     * @return bool
     */
    public function isPaymentMethodEnabled($scope = ScopeInterface::SCOPE_STORE): bool
    {
        return $this->scopeConfig->isSetFlag(self::XML_PATH_SHOW_PAYMENT_METHOD, $scope);
    }

    /**
     * Check if timeline display is enabled
     *
     * @param string $scope
     * @return bool
     */
    public function isTimelineEnabled($scope = ScopeInterface::SCOPE_STORE): bool
    {
        return $this->scopeConfig->isSetFlag(self::XML_PATH_SHOW_TIMELINE, $scope);
    }

    /**
     * Get before text
     *
     * @param string $scope
     * @return null|string
     */
    public function getBeforeTextDetails($scope = ScopeInterface::SCOPE_STORE): ?string
    {
        return $this->scopeConfig->getValue(self::XML_PATH_TEXT_BEFORE, $scope);
    }

    /**
     * Get after text
     *
     * @param string $scope
     * @return null|string
     */
    public function getAfterTextDetails($scope = ScopeInterface::SCOPE_STORE): ?string
    {
        return $this->scopeConfig->getValue(self::XML_PATH_TEXT_AFTER, $scope);
    }

    /**
     * Check if CMS block is enabled
     *
     * @param string $scope
     * @return bool
     */
    public function isCmsBlockEnabled($scope = ScopeInterface::SCOPE_STORE): bool
    {
        return $this->scopeConfig->isSetFlag(self::XML_PATH_ENABLE_CMS_BLOCK, $scope);
    }

    /**
     * Get CMS block identifier
     *
     * @param string $scope
     * @return null|string
     */
    public function getCmsBlockDetails($scope = ScopeInterface::SCOPE_STORE): ?string
    {
        return $this->scopeConfig->getValue(self::XML_PATH_CMS_BLOCK, $scope);
    }

    /**
     * Check if second CMS block is enabled
     *
     * @param string $scope
     * @return bool
     */
    public function isSecondCmsBlockEnabled($scope = ScopeInterface::SCOPE_STORE): bool
    {
        return $this->scopeConfig->isSetFlag(self::XML_PATH_ENABLE_CMS_BLOCK_2, $scope);
    }

    /**
     * Get second CMS block identifier
     *
     * @param string $scope
     * @return null|string
     */
    public function getSecondCmsBlockDetails($scope = ScopeInterface::SCOPE_STORE): ?string
    {
        return $this->scopeConfig->getValue(self::XML_PATH_CMS_BLOCK_2, $scope);
    }
}