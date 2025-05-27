# Amadeco Order Success Module for Magento 2

[![Latest Stable Version](https://img.shields.io/github/v/release/iparmentier/magento2-order-success)](https://github.com/iparmentier/magento2-order-success/releases)
[![Magento 2](https://img.shields.io/badge/Magento-2.4.x-brightgreen.svg)](https://magento.com)
[![PHP](https://img.shields.io/badge/PHP-8.1+-blue.svg)](https://www.php.net)
[![License](https://img.shields.io/github/license/iparmentier/magento2-order-success)](https://github.com/iparmentier/magento2-order-success/blob/main/LICENSE.txt)

[SPONSOR: Amadeco](https://www.amadeco.fr)

This module by Amadeco enhances the Magento 2 order confirmation page by adding a detailed summary and visual timeline, based on Baymard Institute recommendations to optimize the post-purchase experience.

Based on [order-information-on-success-page-m2](https://github.com/mavenbird/order-information-on-success-page-m2)

## Features

<img width="1147" alt="Screenshot" src="https://github.com/user-attachments/assets/2108eb60-5ed9-41dd-b641-30d63e785c15" />

### 🎯 Complete Order Summary
- **Detailed item breakdown** with prices, quantities, and properly displayed VAT
- **Shipping and billing addresses** formatted and clear
- **Shipping and payment methods** visible at a glance
- **Detailed totals** with native Magento VAT handling

### 📍 Visual Step Timeline
- **Clear process visualization**: Order Placed → Payment Confirmed → Processing → Shipped
- **Real-time status** based on native Magento states
- **Reduced post-purchase anxiety** through transparent communication
- **Decreased customer service contacts** (up to 30% based on our feedback)

### 🔧 Advanced Customization
- **Customizable text** before and after order details
- **CMS block integration** for targeted marketing content
- **Granular configuration** to show/hide each element
- **Multilingual support** with French translations included

## Installation

```bash
composer require amadeco/module-order-success
bin/magento module:enable Amadeco_OrderSuccess
bin/magento setup:upgrade
bin/magento setup:di:compile
bin/magento cache:clean
```

## Requirements

- PHP 8.1+
- Magento 2.4.x
- Magento_Checkout module
- Magento_Sales module
- Magento_Tax module

## Configuration

Navigate to **Stores > Configuration > Sales > Order Success Page**

### Available Options:

#### General Settings
- **Enable Enhanced Success Page**: Enable/disable the module
- **Show Order Items**: Display ordered items details
- **Show Shipping Address**: Display shipping address
- **Show Billing Address**: Display billing address
- **Show Shipping Method**: Display shipping method
- **Show Payment Method**: Display payment method
- **Show Order Timeline**: Display order status timeline

#### Content Customization
- **Text Above Order Details**: Custom text above the summary
- **Text Under Order Details**: Custom text below the summary
- **CMS Block**: First CMS block integration
- **CMS Block 2**: Second CMS block integration

## Usage

After installation and configuration, the enhanced success page automatically displays after each validated order.

### For Developers

The module uses native Magento events and preferences for robust integration:

```php
// Get order information
$order = $block->getOrder();

// Check if an element should be displayed
if ($block->canShowShippingAddress()) {
    // Display address
}
```

## Why This Module?

### 📊 Based on Baymard Institute Studies

Our module addresses issues identified in checkout optimization studies:

1. **68% of users** expect to see a complete order summary
2. **Lack of clear information** generates post-purchase anxiety
3. **A visual timeline** significantly reduces customer service contacts

### 🛡️ Advantages Over Alternatives

Unlike the original "order-information-on-success-page-m2" module, our solution:

- ✅ **Properly handles VAT** through native Magento_Tax integration
- ✅ **Uses Magento 2 framework** for better robustness
- ✅ **Adds a visual timeline** missing from other modules
- ✅ **Optimized for French e-commerce** with included translations
- ✅ **Modular architecture** allowing fine customization

## Technical Structure

### Module Architecture

```
Amadeco/OrderSuccess/
├── Block/
│   └── Order/
│       ├── Success.php      # Main block
│       ├── Info.php         # Order information
│       ├── Items.php        # Ordered items
│       ├── Timeline.php     # Visual timeline
│       └── Totals.php       # Totals with VAT
├── Helper/
│   └── Data.php            # Configuration helper
├── etc/
│   ├── module.xml          # Module declaration
│   ├── config.xml          # Default configuration
│   └── adminhtml/
│       └── system.xml      # Admin configuration
├── i18n/
│   └── fr_FR.csv          # French translations
└── view/
    └── frontend/
        ├── layout/
        │   └── checkout_onepage_success.xml
        ├── templates/
        │   └── order/          # Custom templates
        └── web/
            └── css/
                └── order-success.css
```

### Key Technical Points

- **Native VAT handling**: Uses `Magento\Tax\Block\Sales\Order\Tax` block
- **Dynamic timeline**: Based on Magento order states (`STATE_NEW`, `STATE_PROCESSING`, etc.)
- **Responsive design**: Adaptive CSS for mobile and desktop

## Support and Contribution

For questions or improvement suggestions:
- Email: contact@amadeco.fr
- Issues: [GitHub Issues](https://github.com/Amadeco/magento2-order-success/issues)

## License

This module is licensed under the Open Software License ("OSL") v3.0. See the [LICENSE.txt](LICENSE.txt) file for details.
