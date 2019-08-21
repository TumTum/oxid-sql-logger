<?php
/**
 * Autor: Tobias Matthaiou <developer@tobimat.eu>
 * Date: 2019-08-20
 * Time: 21:33
 */

namespace tm\oxid\sql\logger;

use Doctrine\DBAL\Logging\SQLLogger;
use Monolog;

/**
 * Class OxidSQLLogger
 * @package tm\oxid\sql\logger
 */
class OxidSQLLogger implements SQLLogger
{
    /**
     * @inheritDoc
     */
    public function __construct()
    {
        if (!Monolog\Registry::hasLogger('sql')) {
            Monolog\Registry::addLogger((new LoggerFactory())->create('sql'));
        }
    }

    /**
     * @inheritDoc
     */
    public function startQuery($sql, array $params = null, array $types = null)
    {
        Monolog\Registry::sql()->addDebug($sql, ['params' => $params, 'types' => $types]);
    }

    /**
     * @inheritDoc
     */
    public function stopQuery()
    {
    }
}
