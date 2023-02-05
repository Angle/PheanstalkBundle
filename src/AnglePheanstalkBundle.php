<?php

namespace Angle\PheanstalkBundle;

use Angle\PheanstalkBundle\DependencyInjection\Compiler\ProxyCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class AnglePheanstalkBundle extends Bundle
{
    /**
     * @inheritdoc
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new ProxyCompilerPass());
    }
}
