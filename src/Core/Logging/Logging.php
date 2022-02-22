<?php

namespace PS\Source\Core\Logging;

class Logging
{
    const LOG_PATH = __DIR__ . '../../../..' . '/logs/';
    const LOG_FILE = self::LOG_PATH . 'log.log';
    const LOG_FILE_EXTENDED = self::LOG_PATH . 'log_extended.log';

    public function add(string $message, bool $extended = false): void
    {
        $date = date('Y-m-d H:i:s', time());
        $logEntry = '[' . $date . '] : ' . $message . "\r\n";
        if (!$extended) {
            file_put_contents(self::LOG_FILE, $logEntry, FILE_APPEND);
            file_put_contents(self::LOG_FILE_EXTENDED, $logEntry, FILE_APPEND);
        } else {
            file_put_contents(self::LOG_FILE_EXTENDED, $logEntry, FILE_APPEND);
        }
    }

    public function generateFiles(): void
    {
        if (!file_exists(self::LOG_PATH)) {
            mkdir(self::LOG_PATH, 0777, true);
        }

        $logFile = self::LOG_FILE;
        $logExtendedFile = self::LOG_FILE_EXTENDED;

        if (!file_exists($logFile)) {
            $fh = fopen($logFile, 'wb');
            fwrite($fh, '');
        }


        if (!file_exists($logExtendedFile)) {
            $fh = fopen($logExtendedFile, 'wb');
            fwrite($fh, '');
        }

        chmod(self::LOG_PATH, 0755);
    }

    public static function getInstance(): self
    {
        return new self;
    }
}
