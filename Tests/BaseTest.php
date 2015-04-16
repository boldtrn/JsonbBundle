<?php
/**
 * Created by PhpStorm.
 * User: robin
 * Date: 14.04.15
 * Time: 13:48
 */

namespace Boldtrn\JsonbBundle\Tests;

use Doctrine\Common\Cache\ArrayCache;
use Doctrine\ORM\Configuration;

abstract class BaseTest extends \PHPUnit_Framework_TestCase {

    public $entityManager = null;
    protected function setUp()
    {
        if (!class_exists('\Doctrine\ORM\Configuration')) {
            $this->markTestSkipped('Doctrine is not available');
        }
        $config = new Configuration();
        $config->setMetadataCacheImpl(new ArrayCache());
        $config->setQueryCacheImpl(new ArrayCache());
        $config->setProxyDir(__DIR__ . '/Proxies');
        $config->setProxyNamespace('Boldtrn\JsonbBundle\Tests\Proxies');
        $config->setAutoGenerateProxyClasses(true);
        $config->setMetadataDriverImpl($config->newDefaultAnnotationDriver(__DIR__ . '/Entities'));
        $config->addEntityNamespace('E', 'Boldtrn\JsonbBundle\Tests\Entities');
        $config->setCustomStringFunctions(array(
            'JSONB_AG'         => 'Boldtrn\JsonbBundle\Query\JsonbAtGreater',
            'JSONB_HGG'         => 'Boldtrn\JsonbBundle\Query\JsonbHashGreaterGreater',
        ));

        $dbParams = array(
            'driver'   => 'pdo_pgsql',
            'host' => 'localhost',
            'port' => '5432',
            'dbname' => 'jsonb_test',
            'user' => 'postgres',
            'password' => 'secret',
        );

        $this->entityManager = \Doctrine\ORM\EntityManager::create(
            $dbParams,
            $config
        );
    }

}