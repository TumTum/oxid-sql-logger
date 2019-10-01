<?php

namespace spec\tm\oxid\sql\logger\Config;

use tm\oxid\sql\logger\Config\GrayLog;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class GrayLogSpec
 * @package spec\tm\oxid\sql\logger\Config
 */
class GrayLogSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(GrayLog::class);
    }

    public function it_should_be_able_to_read_the_configs()
    {
        $this->isEnableGrayLog()->shouldBe(false);
    }

    public function it_should_be_able_to_read_the_host()
    {
        $this->getHost()->shouldBe('host.docker.internal');
    }

    public function it_should_be_able_to_read_the_port()
    {
        $this->getPort()->shouldBe(12201);
    }
}
