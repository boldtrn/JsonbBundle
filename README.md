JsonbBundle
============

This Symfony2 Bundle extends Doctrine to use the `jsonb` Datatype that ships with Postgresql 9.4.
Please make sure you have Postgresql with a version of at least 9.4 installed before using this bundle.
The Bundle allows to create Jsonb fields and use the Contains and the Like operator on the Jsonb field.
Other Operations can be easily added.
However, at the moment I don't need more.
Feel free to create a PR.

Installation
============

Step 1: Download the Bundle
---------------------------

Open a command console, enter your project directory and execute the
following command to download the latest stable version of this bundle:

```bash
$ composer require "boldtrn/jsonb-bundle": "dev-master"
```

Step 2: Enable the Bundle
-------------------------

Then, enable the bundle by adding the following line in the `app/AppKernel.php`
file of your project:

```php
<?php
// app/AppKernel.php

// ...
class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            // ...

            new Boldtrn\JsonbBundle\JsonbBundle(),
        );

        // ...
    }

    // ...
}
```

Step 3: Add the new Types and Functions to the Config
-------------------------

```
# config.yml
doctrine:
    dbal:
        types:
          jsonb: AppBundle\Types\JsonbArrayType
        mapping_types:
          jsonb: jsonb
    orm:
        dql:
            string_functions:
                JSONB_CONTAINS:   AppBundle\Query\JsonbContains
                JSONB_LIKE:       AppBundle\Query\JsonbLike


```
