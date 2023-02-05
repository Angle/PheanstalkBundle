<?php

namespace Angle\PheanstalkBundle\Tests\Exception;

use Angle\PheanstalkBundle\Exceptions\PheanstalkException;
use PHPUnit\Framework\TestCase;

class PheanstalkExceptionTest extends TestCase
{
    public function testConstructor()
    {
        $exception = new PheanstalkException();

        $this->assertEquals('Pheanstalk exception.', $exception->getMessage());
    }
}
