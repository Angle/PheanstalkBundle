## Configuration

This bundle can be configured, and this is the list of what you can do :
* Create many pheanstalk client.
* Define specific server / host for each connection.
* Define specific port for each connection. This option is optional and default value is 11300.
* Define specific timeout for each connection. Timeout refere to the connection timeout. This option is optional and default value is 60.
* Use custom proxy for pheanstalk client.
* Disable this bundle. This options is optional and default value is true.

``` yaml
# app/config/config.yml
pheanstalk:
    pheanstalks:
        primary:
            server: beanstalkd.domain.tld
            port: 11300
            timeout: 60
        secondary:
            server: beanstalkd-2.domain.tld
            default: true
            proxy: acme.pheanstalk
    profiler:
        enabled: true
        template: 'PheanstalkBundle:Profiler:pheanstalk.html.twig'
```

*acme.pheanstalk* is a custom proxy which implements the *Angle\PheanstalkBundle\Proxy\PheanstalkProxyInterface* interface.

**Note:**
```
    You can retreive each pheanstalk using the container with "angle.pheanstalk.[pheanstalk_name]".
    When you define a "default" pheanstalk. You can have a direct access to it with "angle.pheanstalk".
```

``` php
<?php

namespace Acme\DemoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomeController extends Controller
{
    public function indexAction()
    {
        $pheanstalkPrimary = $this->get("angle.pheanstalk.primary");
        $pheanstalkSecondary = $this->get("angle.pheanstalk");

        // ----------------------------------------
        // producer (queues jobs) on beanstalk.domain.tld

        $pheanstalkDefault
            ->useTube('testtube')
            ->put("job payload goes here\n");

        // ----------------------------------------
        // worker (performs jobs) on beanstalk-2.domain.tld

        $job = $pheanstalkSecondary
            ->watch('testtube')
            ->ignore('default')
            ->reserve();

        echo $job->getData();

        $pheanstalkSecondary->delete($job);

        // ----------------------------------------
        // on each defined pheanstalks
        $pheanstalkLocator = $this->get("angle.pheanstalk.pheanstalk_locator");

        foreach ($pheanstalkLocator->getPheanstalks() as $pheanstalk) {
            $pheanstalk
                ->useTube('boardcast')
                ->put("job payload goes here\n");
        }
    }
}
```
