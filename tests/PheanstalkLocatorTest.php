<?php

namespace Angle\PheanstalkBundle\Tests;

use Angle\PheanstalkBundle\PheanstalkLocator;
use Pheanstalk\Contract\PheanstalkInterface;
use PHPUnit\Framework\TestCase;

class PheanstalkLocatorTest extends TestCase
{
    public function testDefaultPheanstalks()
    {
        $pheanstalkLocator = new PheanstalkLocator();

        $this->assertNotNull($pheanstalkLocator->getPheanstalks());
    }

    public function testGetNoDefinedPheanstalk()
    {
        $pheanstalk = $this->getMockForAbstractClass(PheanstalkInterface::class);

        $pheanstalkLocator = new PheanstalkLocator();
        $pheanstalkLocator->addPheanstalk('default', $pheanstalk);

        $this->assertNull($pheanstalkLocator->getPheanstalk('john.doe'));
    }

    public function testGetDefaultPheanstalk()
    {
        $pheanstalkA = $this->getMockForAbstractClass(PheanstalkInterface::class);
        $pheanstalkB = $this->getMockForAbstractClass(PheanstalkInterface::class);

        $pheanstalkLocator = new PheanstalkLocator();
        $pheanstalkLocator->addPheanstalk('default', $pheanstalkA, true);
        $pheanstalkLocator->addPheanstalk('foo', $pheanstalkB);

        $this->assertEquals($pheanstalkA, $pheanstalkLocator->getPheanstalk());
        $this->assertEquals($pheanstalkA, $pheanstalkLocator->getDefaultPheanstalk());
        $this->assertEquals($pheanstalkA, $pheanstalkLocator->getPheanstalk('default'));
        $this->assertEquals($pheanstalkB, $pheanstalkLocator->getPheanstalk('foo'));
        $this->assertEquals(
            ['default' => $pheanstalkA, 'foo' => $pheanstalkB],
            $pheanstalkLocator->getPheanstalks()
        );
    }
}
