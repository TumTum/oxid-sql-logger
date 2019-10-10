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
     * @var SQLQuery
     */
    private $SQLQuery = null;

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
        if ($this->SQLQuery) {
            $this->SQLQuery->setCanceled();
            $this->stopQuery();
        }

        $this->SQLQuery = (new SQLQuery()) ->setSql($sql)
                                            ->setParams($params)
                                            ->setTypes($types);
    }

    /**
     * @inheritDoc
     */
    public function stopQuery()
    {
        if ($this->SQLQuery) {
            Monolog\Registry::sql()->addDebug(
                '['.$this->SQLQuery->getReadableElapsedTime().'] ' . $this->SQLQuery->getSql(),
                [
                    'params' => $this->SQLQuery->getParams(),
                    'time' => $this->SQLQuery->getElapsedTime(),
                    'types' => $this->SQLQuery->getTypes(),
                    'sameSQLs' => md5($this->SQLQuery->getSql()),
                ]
            );
        }

        $this->SQLQuery = null;
    }
}
