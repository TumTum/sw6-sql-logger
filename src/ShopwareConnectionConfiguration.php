<?php
/**
 * Autor: Tobias Matthaiou <developer@tobimat.eu>
 * Date: 2019-08-20
 * Time: 21:56
 */

namespace tm\sw6\sql\logger;

use Doctrine\DBAL\Logging\EchoSQLLogger;

/**
 * Class OxidEsalesDatabase
 * Is a depenction injection Helper Class
 *
 * @package tm\sw6\sql\logger
 */
class ShopwareConnectionConfiguration
{
    private static $backUplogger = null;

    public static function enableLogger()
    {
        $configuration = \Shopware\Production\Kernel::getConnection()->getConfiguration();

        if ($configuration->getSQLLogger() && ! $configuration->getSQLLogger() instanceof ShopwareDalSQLLogger) {
            self::$backUplogger = $configuration->getSQLLogger();
        }

        $configuration->setSQLLogger(
            new ShopwareDalSQLLogger()
        );
    }

    public static function disableLogger()
    {
        \Shopware\Production\Kernel::getConnection()->getConfiguration()->setSQLLogger(
            self::$backUplogger
        );
    }
}
