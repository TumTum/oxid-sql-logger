<?php

namespace spec\tm\oxid\sql\logger;

use PhpSpec\Exception\Example\FailureException;
use tm\oxid\sql\logger\OxidSQLLogger;
use PhpSpec\ObjectBehavior;
use Monolog;
use function bovigo\assert\predicate\hasKey;
use function bovigo\assert\predicate\isOfType;
use function bovigo\assert\predicate\isSameAs;

class OxidSQLLoggerSpec extends ObjectBehavior
{
    /**
     * @var Monolog\Handler\TestHandler
     */
    private $testLogger = null;

    public function let()
    {
        $this->testLogger = new Monolog\Handler\TestHandler();
        Monolog\Registry::addLogger(
            new Monolog\Logger('sql', [$this->testLogger]),
            'sql',
            true
        );
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(OxidSQLLogger::class);
    }

    /**
     * @throws FailureException
     */
    public function it_should_log_the_sql_normally()
    {
        $this->startQuery('SELECT 1', ['param1'], ['master']);
        for ($i = 0; $i <= 1000; $i++) @get_declared_classes();
        $this->stopQuery();

        $this->assertExpectLog();
        $this->assertMatchMessage('/\[\d+ms\] SELECT 1/');

        $this->assertContext('params',  isSameAs(['param1']));
        $this->assertContext('types',  isSameAs(['master']));
        $this->assertContext('time',  isOfType('float'));

    }

    /**
     * @throws FailureException
     */
    public function it_should_log_without_time_specification()
    {
        $this->startQuery('SELECT 1');
        $this->startQuery('SELECT 2');

        $this->assertExpectLog();
        $this->assertMatchMessage('/\[Statement canceled\] SELECT 1/');
        $this->assertContext('time',  isSameAs('Statement canceled'));

    }

    private function assertExpectLog()
    {
        if (!$this->testLogger->hasRecords(Monolog\Logger::DEBUG)) {
            throw new FailureException("No log entry was made");
        }
    }

    private function assertMatchMessage($regex)
    {
        if (!$this->testLogger->hasRecordThatMatches($regex, Monolog\Logger::DEBUG)) {
            $message = $this->testLogger->getRecords()[0]['message'];
            throw new FailureException("Expect message '{$regex}' got '{$message}'");
        };
    }

    private function assertContext($param, $actual)
    {
        $record = $this->testLogger->getRecords()[0];

        \bovigo\assert\assert($record['context'], hasKey($param), "Context '{$param}' not found");
        \bovigo\assert\assert($record['context'][$param], $actual, "Context '{$param} is not same");
    }
}
