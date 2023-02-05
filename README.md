## PheanstalkBundle
[Symfony Bundle](https://symfony.com) for [Pheanstalk](https://github.com/pda/pheanstalk) – A PHP client for the [beanstalkd workqueue](https://beanstalkd.github.io).

Forked from [armetiz/LeezyPheanstalkBundle](https://github.com/armetiz/LeezyPheanstalkBundle).

Uses the [Pheanstalk](https://github.com/pda/pheanstalk) PHP client by [Paul Annesley](https://paul.annesley.cc/)


This package is a Symfony Bundle that provides the following features:
* Command Line Interface for manage the queues.
* An integration to the Symfony event system.
* An integration to the Symfony profiler system to monitor your beanstalk server.
* An integration to the Symfony logger system.
* A proxy system to customize the command features.
* Auto-wiring: `PheanstalkInterface`

Support Symfony 5.


Documentation :
- [Installation](https://github.com/Angle/PheanstalkBundle/blob/master/src/Resources/doc/1-installation.md)
- [Configuration](https://github.com/Angle/PheanstalkBundle/blob/master/src/Resources/doc/2-configuration.md)
- [CLI Usage](https://github.com/Angle/PheanstalkBundle/blob/master/src/Resources/doc/3-cli.md)
- [Events](https://github.com/Angle/PheanstalkBundle/blob/master/src/Resources/doc/4-events.md)
- [Custom proxy](https://github.com/Angle/PheanstalkBundle/blob/master/src/Resources/doc/5-custom-proxy.md)


## Usage example

```php
<?php

namespace Acme\DemoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomeController extends Controller {

    public function indexAction() {
        $pheanstalk = $this->get("angle.pheanstalk");

        // ----------------------------------------
        // producer (queues jobs)

        $pheanstalk
          ->useTube('testtube')
          ->put("job payload goes here\n");

        // ----------------------------------------
        // worker (performs jobs)

        $job = $pheanstalk
          ->watch('testtube')
          ->ignore('default')
          ->reserve();

        echo $job->getData();

        $pheanstalk->delete($job);
    }

}
?>
```

## Testing

```bash
$ composer update
$ phpunit
```

## License

This bundle is under the MIT license. [See the complete license](https://github.com/Angle/PheanstalkBundle/blob/master/LICENSE).


## Credits
Current Maintainers: [Angle Consulting](https://angle.mx)

Original Author - [Thomas Tourlourat](http://www.armetiz.info)

Original Contributors:
* [dontub](https://github.com/dontub) : Version 4
* [Peter Kruithof](https://github.com/pkruithof) : Version 3
* [Maxwell2022](https://github.com/Maxwell2022) : Symfony2 Profiler integration


