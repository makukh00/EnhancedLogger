# Enhanced Logger for Magento 2

## Overview
This Magento 2 module provides an enhanced logging solution with configurable log levels and custom formatting.

## Features
- Configurable logging via Magento admin
- Rotating log files
- Custom log formatting
- Ability to set log levels
- Adds application area to log context
- 
## Usage
```php
// In a class with dependency injection
public function __construct(
    \YourVendor\EnhancedLogger\Helper\Data $loggerHelper
) {
    $this->loggerHelper = $loggerHelper;
}

// Log messages
$this->loggerHelper->log('Debug message', 'debug');
$this->loggerHelper->log('Info message');
$this->loggerHelper->log('Warning message', 'warning');
$this->loggerHelper->log('Error message', 'error');
```

## License
MIT License
