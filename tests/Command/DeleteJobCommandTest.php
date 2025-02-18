<?php

namespace Angle\PheanstalkBundle\Tests\Command;

use Angle\PheanstalkBundle\Command\DeleteJobCommand;
use Pheanstalk\JobId;
use Symfony\Component\Console\Tester\CommandTester;

class DeleteJobCommandTest extends AbstractPheanstalkCommandTest
{
    public function testExecute()
    {
        $args = $this->getCommandArgs();
        $jobId = new JobId($args['job']);

        $this->pheanstalk->expects($this->once())->method('delete')->with($jobId);

        $command = $this->application->find('pheanstalk:delete-job');
        $commandTester = new CommandTester($command);
        $commandTester->execute($args);
        $this->assertStringContainsString(sprintf('Job %d deleted', $jobId->getId()), $commandTester->getDisplay());
    }

    /**
     * @inheritdoc
     */
    protected function getCommand()
    {
        return new DeleteJobCommand($this->locator);
    }

    /**
     * @inheritdoc
     */
    protected function getCommandArgs()
    {
        return ['job' => 1234];
    }
}
