<?php

use Angle\PheanstalkBundle\Command\AbstractPheanstalkCommand;
use Angle\PheanstalkBundle\Command\DeleteJobCommand;
use Angle\PheanstalkBundle\Command\FlushTubeCommand;
use Angle\PheanstalkBundle\Command\KickCommand;
use Angle\PheanstalkBundle\Command\KickJobCommand;
use Angle\PheanstalkBundle\Command\ListTubeCommand;
use Angle\PheanstalkBundle\Command\NextReadyCommand;
use Angle\PheanstalkBundle\Command\PauseTubeCommand;
use Angle\PheanstalkBundle\Command\PeekCommand;
use Angle\PheanstalkBundle\Command\PeekTubeCommand;
use Angle\PheanstalkBundle\Command\PutCommand;
use Angle\PheanstalkBundle\Command\StatsCommand;
use Angle\PheanstalkBundle\Command\StatsJobCommand;
use Angle\PheanstalkBundle\Command\StatsTubeCommand;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use function Symfony\Component\DependencyInjection\Loader\Configurator\service;

return static function (ContainerConfigurator $container): void {
    $services = $container->services();

    $services->set('angle.pheanstalk.command.abstract', AbstractPheanstalkCommand::class)
        ->abstract()
        ->args([service('angle.pheanstalk.pheanstalk_locator')])
    ;
    $services->set('angle.pheanstalk.command.delete_job', DeleteJobCommand::class)
        ->parent('angle.pheanstalk.command.abstract')
        ->public()
        ->tag('console.command')
    ;
    $services->set('angle.pheanstalk.command.flush_tube', FlushTubeCommand::class)
        ->parent('angle.pheanstalk.command.abstract')
        ->public()
        ->tag('console.command')
    ;
    $services->set('angle.pheanstalk.command.kick', KickCommand::class)
        ->parent('angle.pheanstalk.command.abstract')
        ->public()
        ->tag('console.command')
    ;
    $services->set('angle.pheanstalk.command.kick_job', KickJobCommand::class)
        ->parent('angle.pheanstalk.command.abstract')
        ->public()
        ->tag('console.command')
    ;
    $services->set('angle.pheanstalk.command.list_tube', ListTubeCommand::class)
        ->parent('angle.pheanstalk.command.abstract')
        ->public()
        ->tag('console.command')
    ;
    $services->set('angle.pheanstalk.command.next_ready', NextReadyCommand::class)
        ->parent('angle.pheanstalk.command.abstract')
        ->public()
        ->tag('console.command')
    ;
    $services->set('angle.pheanstalk.command.pause_tube', PauseTubeCommand::class)
        ->parent('angle.pheanstalk.command.abstract')
        ->public()
        ->tag('console.command')
    ;
    $services->set('angle.pheanstalk.command.peek', PeekCommand::class)
        ->parent('angle.pheanstalk.command.abstract')
        ->public()
        ->tag('console.command')
    ;
    $services->set('angle.pheanstalk.command.peek_tube', PeekTubeCommand::class)
        ->parent('angle.pheanstalk.command.abstract')
        ->public()
        ->tag('console.command')
    ;
    $services->set('angle.pheanstalk.command.put', PutCommand::class)
        ->parent('angle.pheanstalk.command.abstract')
        ->public()
        ->tag('console.command')
    ;
    $services->set('angle.pheanstalk.command.stats', StatsCommand::class)
        ->parent('angle.pheanstalk.command.abstract')
        ->public()
        ->tag('console.command')
    ;
    $services->set('angle.pheanstalk.command.stats_job', StatsJobCommand::class)
        ->parent('angle.pheanstalk.command.abstract')
        ->public()
        ->tag('console.command')
    ;
    $services->set('angle.pheanstalk.command.stats_tube', StatsTubeCommand::class)
        ->parent('angle.pheanstalk.command.abstract')
        ->public()
        ->tag('console.command')
    ;
};
