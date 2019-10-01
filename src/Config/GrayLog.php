<?php

namespace tm\oxid\sql\logger\Config;

use Gelf\Transport\StreamSocketClient;
use Symfony\Component\Yaml\Yaml;

/**
 * Class GrayLog
 * @package tm\oxid\sql\logger\Handler
 */
class GrayLog
{
    private static $yaml = null;

    /**
     * @return bool
     */
    public static function isEnableGrayLog()
    {
        $active = self::getConfigParam('active');

        return $active === true;
    }

    /**
     * @return string
     */
    public static function getHost()
    {
        return self::getConfigParam('host');
    }

    /**
     * @return string
     */
    public static function getPort()
    {
        return self::getConfigParam('port');
    }

    /**
     * @return array
     * @throws \Exception
     */
    private static function getConfig()
    {
        if (self::$yaml === null) {
            $yaml = Yaml::parse(file_get_contents(__DIR__ . '/../../logger_config.yml'));
            if (!isset($yaml['graylog'])) {
                throw new \Exception('No `graylog:` found in' . __DIR__ . '/../../logger_config.yml');
            }
            self::$yaml = $yaml['graylog'];
        }

        return self::$yaml;
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    private static function getConfigParam($param)
    {
        $config = self::getConfig();

        if (!isset($config[$param])) {
            throw new \Exception("No `graylog.{$param}:` found in" . __DIR__ . '/../../logger_config.yml');
        }

        return $config[$param];
    }
}
