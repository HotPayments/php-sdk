# HotPayments PHP SDK

A modern, fluent PHP SDK for the HotPayments API. This SDK provides an easy-to-use interface for integrating HotPayments services into your PHP applications.

## Installation

Install the SDK via Composer:

```bash
composer require hotpayments/php
```

## Quick Start

### Basic Usage

```php
<?php

require_once 'vendor/autoload.php';

use HotPayments\Hotpayments;

// Set your API key
Hotpayments::auth('your-api-key-here');

// Create a customer
$customer = Hotpayments::customers()->create([
    'name' => 'John Doe',
    'email' => 'john@example.com',
    'phone_number' => '1111111111',
    'document' => '11111111111'
]);

// List customers with pagination
$customers = Hotpayments::customers()->list(['per_page' => 10]);

// Create a PIX QR Code transaction
$transaction = Hotpayments::transactions()->createPixQrCode([
    'amount' => 100.50,
    'customer_id' => 'customer-uuid-here',
    'description' => 'Payment for services'
]);

// Check transaction status
$status = Hotpayments::transactions()->check('transaction-uuid-here');
```

## Authentication

The SDK requires an API key for authentication. You can set it globally using the `auth` method:

```php
Hotpayments::auth('your-api-key-here');
```

## Services

### Customers Service

```php
// Create a new customer
$customer = Hotpayments::customers()->create([
    'name' => 'John Doe',
    'email' => 'john@example.com',
    'phone_number' => '1111111111',
    'document' => '11111111111'
]);

// List all customers with pagination
$customers = Hotpayments::customers()->list([
    'per_page' => 15,
    'page' => 1
]);
```

### Subscriptions Service

```php
// Create a subscription
$subscription = Hotpayments::subscriptions()->create([
    'customer_id' => 'customer-uuid',
    'plan_id' => 'plan-uuid',
    'payment_method' => 'pix'
]);

// Get subscription details
$subscription = Hotpayments::subscriptions()->show('subscription-uuid');

// Cancel a subscription
$result = Hotpayments::subscriptions()->cancel('subscription-uuid', [
    'reason' => 'Customer requested cancellation'
]);

// Suspend a subscription
$result = Hotpayments::subscriptions()->suspend('subscription-uuid', [
    'reason' => 'Payment failure'
]);

// Reactivate a suspended subscription
$result = Hotpayments::subscriptions()->reactivate('subscription-uuid');
```

### Subscription Plans Service

```php
// List all subscription plans
$plans = Hotpayments::subscriptionPlans()->list([
    'per_page' => 20,
    'currency' => 'BRL'
]);

// Alternative method name
$plans = Hotpayments::subscriptionPlans()->all(['currency' => 'BRL']);
```

### Transactions Service

```php
// Create a PIX QR Code
$qrCode = Hotpayments::transactions()->createPixQrCode([
    'amount' => 150.75,
    'customer_id' => 'customer-uuid',
    'description' => 'Payment description',
    'expires_at' => 3600, // 1 hour in seconds
    'splits' => [
        [
            'slug' => 'partner-company',
            'type' => 'percentage',
            'value' => 10.5
        ]
    ]
]);

// Request a PIX cashout
$cashout = Hotpayments::transactions()->pixCashout([
    'amount' => 100.00,
    'pix_key' => 'user@example.com',
    'customer_id' => 'customer-uuid',
    'description' => 'Cashout request'
]);

// Check transaction status
$transaction = Hotpayments::transactions()->check('transaction-uuid');
echo "Status: " . $transaction['data']['status'];
```

## Laravel Integration

First, add your HotPayments configuration to `config/services.php`:

```php
'hotpayments' => [
    'key' => env('HOTPAYMENTS_API_KEY'),
],
```

In your laravel application you can set in your `boot` method of `AppServiceProvider`:

```php
use HotPayments\Hotpayments;

public function boot()
{
    Hotpayments::auth(config('services.hotpayments.key'));
}
```

Then you can use the SDK anywhere in your application:

```php
use HotPayments\Hotpayments;

$customers = Hotpayments::customers()->list();
```

## Error Handling

The SDK provides specific exception classes for different error types:

```php
use HotPayments\Exceptions\ValidationException;
use HotPayments\Exceptions\AuthorizationException;
use HotPayments\Exceptions\HotpaymentsException;

try {
    $customer = Hotpayments::customers()->create([
        'name' => 'John Doe',
        'email' => 'invalid-email', // This will cause a validation error
    ]);
} catch (ValidationException $e) {
    // Handle validation errors
    echo "Validation Error: " . $e->getMessage();
    print_r($e->getErrors()); // Get detailed field errors
} catch (AuthorizationException $e) {
    // Handle authentication/authorization errors
    echo "Auth Error: " . $e->getMessage();
} catch (HotpaymentsException $e) {
    // Handle other API errors
    echo "API Error: " . $e->getMessage();
}
```


## API Reference

### Customer Methods

- `create(array $data)` - Create a new customer
- `list(array $params = [])` - List customers with pagination

### Subscription Methods

- `create(array $data)` - Create a new subscription
- `show(string $id)` - Get subscription details
- `cancel(string $id, array $data = [])` - Cancel a subscription
- `suspend(string $id, array $data = [])` - Suspend a subscription
- `reactivate(string $id)` - Reactivate a suspended subscription

### Subscription Plans Methods

- `list(array $params = [])` - List subscription plans
- `all(array $params = [])` - Alias for list()

### Transaction Methods

- `createPixQrCode(array $data)` - Create a PIX QR code transaction
- `pixCashout(array $data)` - Request a PIX cashout
- `check(string $id)` - Check transaction status

## Requirements

- PHP 8.1 or higher
- cURL extension
- Fileinfo extension
- Guzzle HTTP client

## Support

For support, please contact [contato@hotpayments.net](mailto:contato@hotpayments.net) or visit our documentation.

## License

This package is open-sourced software licensed under the [MIT license](LICENSE).