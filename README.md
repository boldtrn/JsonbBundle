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
$ composer require <package-name> "~1"
```

This command requires you to have Composer installed globally, as explained
in the [installation chapter](https://getcomposer.org/doc/00-intro.md)
of the Composer documentation.

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

            new <vendor>\<bundle-name>\<bundle-long-name>(),
        );

        // ...
    }

    // ...
}
```