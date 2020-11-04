JsonbBundle
============

**Doctrine implemented the `jsonb` datatype with Doctrine DBAL 2.6. I recommend using the official Doctrine implementation. If you cannot upgrade feel free to use this bundle. It still works for me in my current production setting. I will upgrade to the doctrine implementation at some point in time, as well.**
**[Doctrine Mapping Matrix](http://doctrine-orm.readthedocs.org/projects/doctrine-dbal/en/latest/reference/types.html#mapping-matrix)**


This bundle extends Doctrine to use the `jsonb` datatype that ships with Postgresql 9.4.
This bundle is fully compatible with Symfony, but you do not have to use Symfony (see the `composer.json` for dependencies).
Please make sure you have Postgresql with a version of at least 9.4 installed before using this bundle.
The Bundle allows to create Jsonb fields and use the `@>`,`?` and the `#>>` operator on the Jsonb field.
Other Operations can be easily added.

I recently discovered the power of NativeQueries (http://doctrine-orm.readthedocs.org/en/latest/reference/native-sql.html).
Right now I only use NativeQueries when querying. An example is shown below.

[![Build Status](https://travis-ci.org/boldtrn/JsonbBundle.svg?branch=master)](https://travis-ci.org/boldtrn/JsonbBundle)

Installation
============

Step 1: Download the Bundle
---------------------------

Open a command console, enter your project directory and execute the
following command to download the latest stable version of this bundle:

```bash
$ composer require "boldtrn/jsonb-bundle:~1.1"
```

Step 2: Add the new Types and Functions to the Config
-------------------------

```yaml
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
                JSONB_AG:   Boldtrn\JsonbBundle\Query\JsonbAtGreater
                JSONB_HGG:  Boldtrn\JsonbBundle\Query\JsonbHashGreaterGreater
                JSONB_EX:   Boldtrn\JsonbBundle\Query\JsonbExistence
                JSONB_EX_ANY:   Boldtrn\JsonbBundle\Query\JsonbExistenceAny
```

Note: There were people having issues with the above configuration. They had the following exception:
```
[Symfony\Component\Config\Definition\Exception\InvalidConfigurationException]
  Unrecognized options "dql" under "doctrine.orm"
```

This was fixed by changing the dql part in the following (add the `entity_managers` between `orm` and `dql`):
```yaml
doctrine:
    orm:
        entity_managers:
            dql:
```

Step 3: Create a Entity and Use the Jsonb Type
-------------------------

```php
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
    public $attrs = array();

}
```
Step 4.1: Write a Repository Method using a NativeQuery
-------------------------

```php
$q = $this
            ->entityManager
            ->createNativeQuery(
                "
        SELECT t.id, t.attrs
        FROM Test t
        WHERE t.attrs @> 'value'
        "
            , $rsm);
```

You only need to setup the `$rsm` ResultSetMapping according to the Doctrine documentation.

Step 4.2: Write a Repository Method that queries for the jsonb using the custom JSONB_FUNCTIONS
-------------------------

This example shows how to use the contains statement in a WHERE clause.
The `= TRUE` is a workaround for Doctrine that needs an comparison operator in the WHERE clause.

```php
$q = $this
            ->entityManager
            ->createQuery(
                "
        SELECT t
        FROM E:Test t
        WHERE JSONB_AG(t.attrs, 'value') = TRUE
        "
            );
```

This produces the following Query:
```SQL
SELECT t0_.id AS id0, t0_.attrs AS attrs1 FROM Test t0_ WHERE (t0_.attrs @> 'value') = true
```

This example shows how to query for a value that is LIKE `%d%`
The result could be data like:
 ```
  id |                 attrs
 ----+--------------------------------------
   4 | {"a": 1, "b": {"c": "abcdefg", "e": true}}
 ```


```php
        $q = $this
            ->entityManager
            ->createQuery(
                "
        SELECT t
        FROM E:Test t
        WHERE JSONB_HGG(t.attrs , '{\"b\",\"c\"}') LIKE '%d%'
        "
            );
```

This produces the following Query:
```SQL
SELECT t0_.id AS id0, t0_.attrs AS attrs1 FROM Test t0_ WHERE (t0_.attrs #>> '{\"object1\",\"object2\"}') LIKE '%a%'
```


Further Information
-------------------------

The `?` operator is implemented by calling its function `jsonb_exists(column_name, value)` since Doctrine will consider it a parameter placeholder otherwise. The same must be done if you want to implement `?|` and `?&` operators, using `jsonb_exists_any(column_name, value)` and `jsonb_exists_all(column_name, value)` respectively
