<?php

namespace Angle\PheanstalkBundle\Tests\Command;

use Angle\PheanstalkBundle\Command\NextReadyCommand;
use Pheanstalk\Job;
use Symfony\Component\Console\Tester\CommandTester;

class NextReadyCommandTest extends AbstractPheanstalkCommandTest
{
    public function testExecute()
    {
        $args = $this->getCommandArgs();
        $data = 'foobar';
        $job  = new Job(1234, $data);

        $this->pheanstalk->expects($this->once())->method('useTube')->will($this->returnValue($this->pheanstalk));
        $this->pheanstalk->expects($this->once())->method('peekReady')->will($this->returnValue($job));

        $command = $this->application->find('pheanstalk:next-ready');
        $commandTester = new CommandTester($command);
        $commandTester->execute($args);

        $this->assertStringContainsString(sprintf('Next ready job in tube default is %d', $job->getId()), $commandTester->getDisplay());
        $this->assertStringContainsString($data, $commandTester->getDisplay());
    }

    /**
     * @inheritdoc
     */
    protected function getCommand()
    {
        return new NextReadyCommand($this->locator);
    }

    /**
     * @inheritdoc
     */
    protected function getCommandArgs()
    {
        return ['tube' => 'default', '--details' => true];
    }
}
