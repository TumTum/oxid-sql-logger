<?php

namespace spec\tm\oxid\sql\logger;

use tm\oxid\sql\logger\SQLQuery;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class SQLQuerySpec
 * @package spec\tm\oxid\sql\logger
 */
class SQLQuerySpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(SQLQuery::class);
    }

    public function it_hat_sql_setter_getter()
    {
        $this->setSQL('SELECT NOW()')->shouldHaveType(SQLQuery::class);
        $this->getSQL()->shouldBe('SELECT NOW()');
    }

    public function it_hat_params_setter_getter()
    {
        $this->setParams(['param1', 'param2'])->shouldHaveType(SQLQuery::class);
        $this->getParams()->shouldBe(['param1', 'param2']);
    }

    public function it_hat_type_setter_getter()
    {
        $this->setTypes(['type1'])->shouldHaveType(SQLQuery::class);
        $this->getTypes()->shouldBe(['type1']);
    }

    public function it_should_indicate_an_aborted_time()
    {
        $this->setSql('SELECT 1');
        $this->setCanceled()->shouldHaveType(SQLQuery::class);
        $this->getElapsedTime()->shouldBe('Statement canceled');
    }

    public function it_should_display_with_a_readable_time()
    {
        $this->setSql('SELECT 1');
        sleep(1);
        $this->getReadableElapsedTime()->shouldMatch('/^1\.\d\d\ds/');
    }

    public function it_should_display_with_a_readable_time_in_ms()
    {
        $this->setSql('SELECT 1');
        for ($i = 0; $i <= 1000; $i++) @get_declared_classes();
        $this->getReadableElapsedTime()->shouldMatch('/^\d{1,3}ms/');
    }

    public function it_should_display_a_time_in_float()
    {
        $this->setSql('SELECT 1');
        for ($i = 0; $i <= 1000; $i++) @get_declared_classes();
        $this->getElapsedTime()->shouldBeFloat();
    }
}
