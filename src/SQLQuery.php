<?php
/**
 * Autor: Tobias Matthaiou <developer@tobimat.eu>
 * Date: 2019-08-20
 * Time: 21:56
 */

namespace tm\oxid\sql\logger;

/**
 * Class SQLQuery
 * @package tm\oxid\sql\logger
 */
class SQLQuery
{
    /**
     * @var float|null
     */
    private $start_time = null;

    /**
     * @var float|null
     */
    private $stop_time = null;

    /**
     * @var string
     */
    private $sql = '';

    /**
     * @var null
     */
    private $params = null;

    /**
     * @var null
     */
    private $types = null;

    /**
     * @inheritDoc
     */
    public function __construct()
    {
        $this->start_time = microtime(true);
    }

    /**
     * @return string
     */
    public function getSql()
    {
        return $this->sql;
    }

    /**
     * @param string $sql
     * @return SQLQuery
     */
    public function setSql($sql)
    {
        $this->sql = $sql;
        return $this;
    }

    /**
     * @return null
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * @param null $params
     * @return SQLQuery
     */
    public function setParams($params)
    {
        $this->params = $params;
        return $this;
    }

    /**
     * @return null
     */
    public function getTypes()
    {
        return $this->types;
    }

    /**
     * @param null $types
     * @return SQLQuery
     */
    public function setTypes($types)
    {
        $this->types = $types;
        return $this;
    }

    /**
     * Statement was cancelled prematurely, an error was thrown.
     *
     * @return $this
     */
    public function setCanceled()
    {
        $this->start_time = null;
        return $this;
    }

    /**
     * Returns elapsed time
     * @return float|string
     */
    public function getElapsedTime()
    {
        if ($this->start_time === null) {
            return 'Statement canceled';
        }

        if ($this->stop_time === null) {
            $end_time = microtime(true);
            $this->stop_time = $end_time - $this->start_time;
        }

        return (float)$this->stop_time;
    }

    /**
     * Returns a human readable elapsed time
     *
     * @return string
     */
    public function getReadableElapsedTime()
    {
        return $this->readableElapsedTime($this->getElapsedTime());
    }

    /**
     * Returns a human readable elapsed time
     *
     * @param  float $microtime
     * @param  string  $format   The format to display (printf format)
     * @return string
     */
    private function readableElapsedTime($microtime, $format = '%.3f%s', $round = 3)
    {
        if (is_string($microtime)) {
            return $microtime;
        }

        if ($microtime >= 1) {
            $unit = 's';
            $time = round($microtime, $round);
        } else {
            $unit = 'ms';
            $time = round($microtime*1000);

            $format = preg_replace('/(%.[\d]+f)/', '%d', $format);
        }

        return sprintf($format, $time, $unit);
    }
}
