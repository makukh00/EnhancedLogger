<?php
declare(strict_types=1);

namespace Makukh\EnhancedLogger\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\State;
use Magento\Framework\Filesystem\DirectoryList;
use Magento\Framework\Logger\Monolog;
use Monolog\Formatter\LineFormatter;
use Monolog\Handler\RotatingFileHandler;

class Logger extends Monolog
{
    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * @var State
     */
    private $appState;

    /**
     * @var DirectoryList
     */
    private $directoryList;

    public function __construct(
        ScopeConfigInterface $scopeConfig,
        State $appState,
        DirectoryList $directoryList,
                             $name,
        array $handlers = [],
        array $processors = []
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->appState = $appState;
        $this->directoryList = $directoryList;

        parent::__construct($name, $handlers, $processors);
        $this->configureLogger();
    }

    private function configureLogger()
    {
        // Check if enhanced logging is enabled
        $isEnabled = $this->scopeConfig->getValue('enhanced_logger/general/enable');
        if (!$isEnabled) {
            return;
        }

        // Get configured log level
        $logLevel = $this->scopeConfig->getValue('enhanced_logger/general/log_level') ?: self::INFO;
        $levelMap = [
            'debug' => self::DEBUG,
            'info' => self::INFO,
            'warning' => self::WARNING,
            'error' => self::ERROR
        ];
        $logLevelInt = $levelMap[$logLevel] ?? self::INFO;

        // Create a custom log file in the Magento log directory
        $logDir = $this->directoryList->getPath('log');
        $logFile = $logDir . '/enhanced_' . $this->getName() . '.log';

        // Create a rotating file handler
        $handler = new RotatingFileHandler($logFile, 10, $logLevelInt);

        // Custom log format
        $dateFormat = 'Y-m-d H:i:s';
        $output = "[%datetime%] %level_name%: %message% %context% %extra%\n";
        $formatter = new LineFormatter($output, $dateFormat);

        // Add app area and environment to log context
        $this->pushProcessor(function ($record) {
            try {
                $record['extra']['area'] = $this->appState->getAreaCode();
            } catch (\Exception $e) {
                $record['extra']['area'] = 'unknown';
            }
            return $record;
        });

        $handler->setFormatter($formatter);
        $this->pushHandler($handler);
    }
}
