<?php

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use SuiteCRM\Log\CliLoggerFormatter;

class CustomSugarLogger extends SugarLogger
{
    public function __construct()
    {
        parent::__construct();

        if (
            isset($GLOBALS['sugar_config']['logger']['default'])
            && $GLOBALS['sugar_config']['logger']['default'] == 'CustomSugarLogger'
        ) {
            LoggerManager::setLogger('default', 'CustomSugarLogger');
        }

        $this->fp = new Logger('LoggerHandler');
        $this->fp->pushHandler(
            (new StreamHandler('php://stdout', Logger::DEBUG))->setFormatter(new CliLoggerFormatter)
        );
    }

    /**
     * Show log
     * and show a backtrace information in log when
     * the 'show_log_trace' config variable is set and true
     * see LoggerTemplate::log()
     */
    public function log(
        $level,
        $message
    ) {
        // change to a string if there is just one entry
        if (is_array($message) && count($message) == 1) {
            $message = array_shift($message);
        }

        switch ($level) {
            case 'debug':
                $this->fp->debug($message);
                break;
            case 'info':
                $this->fp->info($message);
                break;
            case 'deprecated':
            case 'warn':
                $this->fp->warning($message);
                break;
            case 'error':
            case 'fatal':
            case 'security':
                $this->fp->error($message);
                break;
        }
    }
}
