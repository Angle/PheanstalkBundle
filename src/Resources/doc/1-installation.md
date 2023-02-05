## Installation

Installation is a quick 3 step process:

1. Download AnglePheanstalkBundle using composer
2. Enable the Bundle
3. Configure your application's config.yml

### Step 1: Require AnglePheanstalkBundle

Tell composer to require this bundle by running:

``` bash
$ composer require anglemx/pheanstalk-bundle
```

### Step 2: Enable the bundle

Enable the bundle in the kernel:

``` php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = [
        // ...
        new Angle\PheanstalkBundle\AnglePheanstalkBundle(),
    ];
}
```

### Step 3: Configure your application's config.yml

Finally, add the following to your config.yml

``` yaml
# app/config/config.yml
pheanstalk:
    pheanstalks:
        primary:
            server: beanstalkd.domain.tld
            default: true
```
