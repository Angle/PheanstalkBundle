<?php

namespace Angle\PheanstalkBundle\Tests\DependencyInjection;

use Angle\PheanstalkBundle\DependencyInjection\PheanstalkExtension;
use Angle\PheanstalkBundle\PheanstalkBundle;
use Angle\PheanstalkBundle\Proxy\PheanstalkProxy;
use Angle\PheanstalkBundle\Proxy\PheanstalkProxyInterface;
use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

class PheanstalkExtensionTest extends TestCase
{
    /**
     * @var ContainerBuilder
     */
    private $container;

    /**
     * @var PheanstalkExtension
     */
    private $extension;

    protected function setUp(): void
    {
        $this->container = new ContainerBuilder();
        $this->extension = new PheanstalkExtension();

        $bundle = new PheanstalkBundle();
        $bundle->build($this->container); // Attach all default factories
    }

    protected function tearDown(): void
    {
        unset($this->container, $this->extension);
    }

    public function testInitConfiguration()
    {
        $config = [
            'pheanstalk' => [
                'pheanstalks' => [
                    'primary' => [
                        'server'  => 'beanstalkd.domain.tld',
                        'port'    => 11300,
                        'timeout' => 60,
                        'default' => true,
                    ],
                ],
            ],
        ];
        $this->extension->load($config, $this->container);
        $this->container->compile();

        $this->assertTrue($this->container->hasDefinition('angle.pheanstalk.pheanstalk_locator'));
        $this->assertTrue($this->container->hasParameter('angle.pheanstalk.pheanstalks'));  // Needed by ProxyCompilerPass
    }

    public function testDefaultPheanstalk()
    {
        $config = [
            'pheanstalk' => [
                'pheanstalks' => [
                    'primary' => [
                        'server'  => 'beanstalkd.domain.tld',
                        'port'    => 11300,
                        'timeout' => 60,
                        'default' => true,
                    ],
                ],
            ],
        ];
        $this->extension->load($config, $this->container);
        $this->container->compile();

        $this->assertTrue($this->container->hasDefinition('angle.pheanstalk.primary'));
        $this->assertTrue($this->container->hasAlias('angle.pheanstalk'));
    }

    public function testNoDefaultPheanstalk()
    {
        $config = [
            'pheanstalk' => [
                'pheanstalks' => [
                    'primary' => [
                        'server'  => 'beanstalkd.domain.tld',
                        'port'    => 11300,
                        'timeout' => 60,
                    ],
                ],
            ],
        ];
        $this->extension->load($config, $this->container);
        $this->container->compile();

        $this->assertTrue($this->container->hasDefinition('angle.pheanstalk.primary'));
        $this->assertFalse($this->container->hasAlias('angle.pheanstalk'));
    }

    public function testTwoDefaultPheanstalks()
    {
        $this->expectException(\Angle\PheanstalkBundle\Exceptions\PheanstalkException::class);
        $config = [
            'pheanstalk' => [
                'pheanstalks' => [
                    'one' => [
                        'server'  => 'beanstalkd.domain.tld',
                        'default' => true,
                    ],
                    'two' => [
                        'server'  => 'beanstalkd-2.domain.tld',
                        'default' => true,
                    ],
                ],
            ],
        ];
        $this->extension->load($config, $this->container);
        $this->container->compile();
    }

    public function testMultiplePheanstalks()
    {
        $config = [
            'pheanstalk' => [
                'pheanstalks' => [
                    'one'   => [
                        'server'  => 'beanstalkd.domain.tld',
                        'port'    => 11300,
                        'timeout' => 60,
                    ],
                    'two'   => [
                        'server' => 'beanstalkd-2.domain.tld',
                    ],
                    'three' => [
                        'server' => 'beanstalkd-3.domain.tld',
                    ],
                ],
            ],
        ];
        $this->extension->load($config, $this->container);
        $this->container->compile();

        $this->assertTrue($this->container->hasDefinition('angle.pheanstalk.one'));
        $this->assertTrue($this->container->hasDefinition('angle.pheanstalk.two'));
        $this->assertTrue($this->container->hasDefinition('angle.pheanstalk.three'));

        # @see https://github.com/armetiz/LeezyPheanstalkBundle/issues/61
        $this->assertNotSame($this->container->getDefinition('angle.pheanstalk.one'), $this->container->getDefinition('angle.pheanstalk.two'));
    }

    public function testPheanstalkLocator()
    {
        $config = [
            'pheanstalk' => [
                'pheanstalks' => [
                    'primary' => [
                        'server'  => 'beanstalkd.domain.tld',
                        'port'    => 11300,
                        'timeout' => 60,
                        'default' => true,
                    ],
                ],
            ],
        ];
        $this->extension->load($config, $this->container);
        $this->container->compile();

        $this->assertTrue($this->container->hasDefinition('angle.pheanstalk.pheanstalk_locator'));
    }

    public function testPheanstalkProxyCustomTypeNotDefined()
    {
        $this->expectException(\Symfony\Component\DependencyInjection\Exception\InvalidArgumentException::class);
        $config = [
            'pheanstalk' => [
                'pheanstalks' => [
                    'primary' => [
                        'server'  => 'beanstalkd.domain.tld',
                        'port'    => 11300,
                        'timeout' => 60,
                        'proxy'   => 'acme.pheanstalk.pheanstalk_proxy',
                    ],
                ],
            ],
        ];
        $this->extension->load($config, $this->container);
        $this->container->compile();
    }

    public function testPheanstalkReservedName()
    {
        $this->expectException(\RuntimeException::class);
        $config = [
            'pheanstalk' => [
                'pheanstalks' => [
                    'proxy' => [
                        'server'  => 'beanstalkd.domain.tld',
                        'port'    => 11300,
                        'timeout' => 60,
                        'proxy'   => 'acme.pheanstalk.pheanstalk_proxy',
                    ],
                ],
            ],
        ];
        $this->extension->load($config, $this->container);
        $this->container->compile();
    }

    public function testPheanstalkProxyCustomType()
    {
        $config = [
            'pheanstalk' => [
                'pheanstalks' => [
                    'primary' => [
                        'server'  => 'beanstalkd.domain.tld',
                        'port'    => 11300,
                        'timeout' => 60,
                        'proxy'   => 'acme.pheanstalk.pheanstalk_proxy',
                    ],
                ],
            ],
        ];

        $this->container->setDefinition('acme.pheanstalk.pheanstalk_proxy', new Definition(PheanstalkProxy::class));

        $this->extension->load($config, $this->container);
        $this->container->compile();

        $this->assertNotNull($this->container->get('angle.pheanstalk.primary'));
    }

    public function testLoggerConfiguration()
    {
        $config = [
            'pheanstalk' => [
                'pheanstalks' => [
                    'primary' => [
                        'server'  => 'beanstalkd.domain.tld',
                        'port'    => 11300,
                        'timeout' => 60,
                        'default' => true,
                    ],
                ],
            ],
        ];

        $this->container->setDefinition('logger', new Definition(NullLogger::class));

        $this->extension->load($config, $this->container);
        $this->container->compile();

        $this->assertTrue($this->container->hasDefinition('angle.pheanstalk.listener.log'));
        $listener = $this->container->getDefinition('angle.pheanstalk.listener.log');

        $this->assertTrue($listener->hasMethodCall('setLogger'));
        $this->assertTrue($listener->hasTag('monolog.logger'));

        $tag = $listener->getTag('monolog.logger');
        $this->assertEquals('pheanstalk', $tag[0]['channel']);
    }
}
