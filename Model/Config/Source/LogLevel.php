<?php
declare(strict_types=1);

namespace Makukh\EnhancedLogger\Model\Config\Source;

use Magento\Framework\Option\ArrayInterface;

class LogLevel implements ArrayInterface
{
    const DEBUG = 'debug';
    const INFO = 'info';
    const WARNING = 'warning';
    const ERROR = 'error';

    public function toOptionArray()
    {
        return [
            ['value' => self::DEBUG, 'label' => __('Debug')],
            ['value' => self::INFO, 'label' => __('Info')],
            ['value' => self::WARNING, 'label' => __('Warning')],
            ['value' => self::ERROR, 'label' => __('Error')]
        ];
    }
}
