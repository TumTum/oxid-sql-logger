<?php
/**
 * Autor: Tobias Matthaiou <developer@tobimat.eu>
 * Date: 2019-08-20
 * Time: 21:56
 */

namespace tm\oxid\sql\logger;

use Doctrine\DBAL\Configuration;

/**
 * Class OxidEsalesDatabase
 * Is a depenction injection Helper Class
 *
 * @package tm\oxid\sql\logger
 */
class OxidEsalesDatabase extends \OxidEsales\Eshop\Core\Database\Adapter\Doctrine\Database
{
    public static function enableLogger()
    {
        $database = \OxidEsales\Eshop\Core\DatabaseProvider::getDb(\OxidEsales\Eshop\Core\DatabaseProvider::FETCH_MODE_ASSOC);
        $dbalConfig = $database->getConnection()->getConfiguration();
        $dbalConfig->setSQLLogger(new OxidSQLLogger());
    }

    public static function disableLogger()
    {
        $database = \OxidEsales\Eshop\Core\DatabaseProvider::getDb(\OxidEsales\Eshop\Core\DatabaseProvider::FETCH_MODE_ASSOC);
        $dbalConfig = $database->getConnection()->getConfiguration();
        $dbalConfig->setSQLLogger(null);
    }
}
