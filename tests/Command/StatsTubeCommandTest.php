<?php

namespace Angle\PheanstalkBundle\Tests\Command;

use Angle\PheanstalkBundle\Command\StatsTubeCommand;
use Pheanstalk\Response\ArrayResponse;
use Symfony\Component\Console\Tester\CommandTester;

class StatsTubeCommandTest extends AbstractPheanstalkCommandTest
{
    public function testExecute()
    {
        $args  = $this->getCommandArgs();
        $tube  = 'default';
        $stats = new ArrayResponse('STATS', [
            'foo' => 'bar',
            'bar' => 'baz',
            'baz' => 'qux',
        ]);

        $this->pheanstalk->expects($this->once())->method('listTubes')->will($this->returnValue([$tube]));
        $this->pheanstalk->expects($this->once())->method('statsTube')->with($tube)->will($this->returnValue($stats));

        $command       = $this->application->find('pheanstalk:stats-tube');
        $commandTester = new CommandTester($command);
        $commandTester->execute($args);

        foreach ($stats as $key => $value) {
            $this->assertStringContainsString(sprintf('- %s: %s', $key, $value), $commandTester->getDisplay());
        }
    }

    /**
     * @inheritdoc
     */
    protected function getCommand()
    {
        return new StatsTubeCommand($this->locator);
    }

    /**
     * @inheritdoc
     */
    protected function getCommandArgs()
    {
        return [];
    }
}
