<?php
/**
 * Autor: Tobias Matthaiou <developer@tobimat.eu>
 * Date: 2019-08-21
 * Time: 07:50
 */
namespace tm\oxid\sql\logger;

use Monolog;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;

/**
 * Class Factory
 * @package tm\oxid\sql\logger
 */
class LoggerFactory
{
    /**
     * @param $name
     * @return Monolog\Logger
     */
    public function create($name)
    {
        return new Monolog\Logger($name, $this->getHandlers(), $this->getProcessors());
    }

    /**
     * @return array
     */
    private function getHandlers()
    {
        $handlers = [];
        if (PHP_SAPI == 'cli') {
            $handlers[] = $this->getStreamHandler();
        } else {
            $handlers[] = $this->getBrowserConsoleHandler();
        }
        return $handlers;
    }

    /**
     * @return Monolog\Handler\StreamHandler
     */
    private function getStreamHandler()
    {
        $streamHandler = new Monolog\Handler\StreamHandler('php://stderr');

        $channel    = (new OutputFormatterStyle(null, null, ['bold']))->apply('%channel%');
        $level_name = (new OutputFormatterStyle('blue'))->apply('%level_name%');
        $message    = (new OutputFormatterStyle('green'))->apply('%message%');
        $context    = (new OutputFormatterStyle('yellow'))->apply('%context%');
        $newline    = PHP_EOL . str_repeat(' ', 10);

        $ttl_color = "$channel $level_name: $message {$newline} $context {$newline} %extra%" . PHP_EOL;

        $streamHandler->setFormatter(new Monolog\Formatter\LineFormatter($ttl_color));

        return $streamHandler;
    }

    /**
     * @return Monolog\Handler\BrowserConsoleHandler
     */
    private function getBrowserConsoleHandler()
    {
        return new Monolog\Handler\BrowserConsoleHandler();
    }

    /**
     * @return array
     */
    private function getProcessors()
    {
        return [
            new Monolog\Processor\IntrospectionProcessor(Monolog\Logger::DEBUG, ['tm\\oxid\\sql\\logger', 'Doctrine\\DBAL\\Connection', 'OxidEsales\\EshopCommunity\\Core\\Database\\Adapter\\Doctrine\\Database']),
            new Monolog\Processor\PsrLogMessageProcessor(),
        ];
    }
}
