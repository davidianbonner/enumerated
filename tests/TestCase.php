<?php

namespace DavidIanBonner\Enumerated;

use Mockery;

class TestCase extends \PHPUnit\Framework\TestCase
{
    /**
     * Clean up the testing environment before the next test.
     *
     * @return void
     */
    protected function tearDown()
    {
        if ($container = Mockery::getContainer()) {
            $this->addToAssertionCount($container->mockery_getExpectationCount());
        }

        Mockery::close();
    }
}
