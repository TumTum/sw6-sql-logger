<?php
/**
 * Autor: Tobias Matthaiou <developer@tobimat.eu>
 * Date: 2019-08-20
 * Time: 21:56
 */

namespace tm\sw6\sql\logger;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Logging\EchoSQLLogger;

/**
 * Class OxidEsalesDatabase
 * Is a depenction injection Helper Class
 *
 * @package tm\sw6\sql\logger
 */
class ShopwareConnectionConfiguration
{
    private static mixed $backUplogger = null;

    public static function enableLogger(array $options): void
    {
        $connection = self::getDoctrineConnection();

        if ($connection === null) {
            return;
        }

        $configuration = $connection->getConfiguration();

        if ($configuration->getSQLLogger() && ! $configuration->getSQLLogger() instanceof ShopwareDalSQLLogger) {
            self::$backUplogger = $configuration->getSQLLogger();
        }

        $configuration->setSQLLogger(
            new ShopwareDalSQLLogger($options)
        );
    }

    public static function disableLogger(): void
    {
        $connection = self::getDoctrineConnection();

        if ($connection === null) {
            return;
        }

        $connection->getConfiguration()->setSQLLogger(
            self::$backUplogger
        );

        self::$backUplogger = null;
    }

    private static function getDoctrineConnection(): Connection|null
    {
        /** @var \Shopware\Core\Kernel|null $app */
        global $app;

        if (method_exists($app, 'getKernel')) {
            return $app->getKernel()->getConnection();
        }

        return $app?->getConnection();
    }
}
