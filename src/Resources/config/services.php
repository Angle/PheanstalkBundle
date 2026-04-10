<?php

use Angle\PheanstalkBundle\Proxy\PheanstalkProxy;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use function Symfony\Component\DependencyInjection\Loader\Configurator\service;

return static function (ContainerConfigurator $container): void {
    $container
        ->services()
        ->set('angle.pheanstalk.proxy.default', PheanstalkProxy::class)
            ->public()
            ->call('setDispatcher', [service('event_dispatcher')->ignoreOnInvalid()])
    ;
};
