JsonbBundle
============

This Symfony2 Bundle extends Doctrine to use the `jsonb` Datatype that ships with Postgresql 9.4.
Please make sure you have Postgresql with a version of at least 9.4 installed before using this bundle.
The Bundle allows to create Jsonb fields and use the Contains and the Like operator on the Jsonb field.
Other Operations can be easily added.
However, at the moment I don't need more.
Feel free to create a PR or ask me ;).

The Bundle is stable but the Query functions are a bit inconvenient.

[![Build Status](https://travis-ci.org/boldtrn/JsonbBundle.svg?branch=master)](https://travis-ci.org/boldtrn/JsonbBundle)

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
          jsonb: Boldtrn\JsonbBundle\Types\JsonbArrayType
        mapping_types:
          jsonb: jsonb
    orm:
        dql:
            string_functions:
                JSONB_CONTAINS:   Boldtrn\JsonbBundle\Query\JsonbContains
                JSONB_LIKE:       Boldtrn\JsonbBundle\Query\JsonbLike


```

Step 4: Create a Entity and Use the Jsonb Type
-------------------------

```
/**
 * @Entity
 */
class Test
{

    /**
     * @Id
     * @Column(type="string")
     * @GeneratedValue
     */
    public $id;

    /**
     * @Column(type="jsonb")
     *
     * Usually attrs is an array, depends on you
     *
     */
    public $attrs;

}
```

Step 5: Write a Repository Method that queries for the jsonb 
-------------------------

This example shows how to use the contains statement in a WHERE clause. 
The `= TRUE` is a workaround for Doctrine that needs an comparison operator in the WHERE clause.

```
$q = $this
            ->entityManager
            ->createQuery(
                "
        SELECT t
        FROM E:Test t
        WHERE JSONB_CONTAINS(t.attrs, 'value') = TRUE
        "
            );
```            

This example shows how to query for a value that is LIKE `%d%`
The result could be data like:
 ```
  id |                 attrs                 
 ----+--------------------------------------
   4 | {"a": 1, "b": {"c": "abcdefg", "e": true}}
 ```


```
        $q = $this
            ->entityManager
            ->createQuery(
                "
        SELECT t
        FROM E:Test t
        WHERE JSONB_LIKE(t.attrs , '{\"b\",\"c\"}') LIKE '%d%'
        "
            );
```