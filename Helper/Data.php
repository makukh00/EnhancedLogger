<?php
declare(strict_types=1);

namespace Makukh\EnhancedLogger\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Makukh\EnhancedLogger\Model\Logger;

class Data extends AbstractHelper
{
    /**
     * @var Logger
     */
    private $logger;

    public function __construct(
        Context $context,
        Logger  $logger
    )
    {
        $this->logger = $logger;
        parent::__construct($context);
    }

    public function log($message, $level = 'info', $context = [])
    {
        switch ($level) {
            case 'debug':
                $this->logger->debug($message, $context);
                break;
            case 'warning':
                $this->logger->warning($message, $context);
                break;
            case 'error':
                $this->logger->error($message, $context);
                break;
            default:
                $this->logger->info($message, $context);
        }
    }
}
