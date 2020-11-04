<?php
/**
 * Created by PhpStorm.
 * User: robin
 * Date: 14.04.15
 * Time: 13:48
 */

namespace Boldtrn\JsonbBundle\Tests;

use Doctrine\Common\Cache\ArrayCache;
use \Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Types\Type;
use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\SchemaTool;

abstract class BaseTest extends \PHPUnit_Framework_TestCase
{

    /** @var  EntityManager */
    protected $entityManager;

    /** @var  Connection */
    protected $connection;

    protected $dbParams = array(
        'driver' => 'pdo_pgsql',
        'host' => 'localhost',
        'port' => '5432',
        'dbname' => 'jsonb_test',
        'user' => 'postgres',
        'password' => 'secret',
    );

    protected $testEntityName = 'Boldtrn\JsonbBundle\Tests\Entities\Test';

    protected function setUp()
    {

        if (!class_exists('\Doctrine\ORM\Configuration')) {
            static::markTestSkipped('Doctrine is not available');
        }

        $config = new Configuration();
        $config->setMetadataCacheImpl(new ArrayCache());
        $config->setQueryCacheImpl(new ArrayCache());
        $config->setProxyDir(__DIR__.'/Proxies');
        $config->setProxyNamespace('Boldtrn\JsonbBundle\Tests\Proxies');
        $config->setAutoGenerateProxyClasses(true);
        $config->setMetadataDriverImpl($config->newDefaultAnnotationDriver(__DIR__.'/Entities'));
        $config->addEntityNamespace('E', 'Boldtrn\JsonbBundle\Tests\Entities');
        $config->setCustomStringFunctions(
            array(
                'JSONB_AG' => 'Boldtrn\JsonbBundle\Query\JsonbAtGreater',
                'JSONB_HGG' => 'Boldtrn\JsonbBundle\Query\JsonbHashGreaterGreater',
                'JSONB_EX' => 'Boldtrn\JsonbBundle\Query\JsonbExistence',
                'JSONB_EX_ANY' => 'Boldtrn\JsonbBundle\Query\JsonbExistenceAny',
            )
        );


        $this->entityManager = EntityManager::create(
            $this->dbParams,
            $config
        );

        $this->connection = $this->entityManager->getConnection();

        $this->setUpDBALTypes();

        $tool = new SchemaTool($this->entityManager);
        $classes = $this->entityManager->getMetaDataFactory()->getAllMetaData();


        // Drop all classes and re-build them for each test case
        $tool->dropSchema($classes);
        $tool->createSchema($classes);

    }

    /**
     * Configures DBAL types required in tests
     */
    protected function setUpDBALTypes()
    {

        if (Type::hasType('jsonb')) {
            Type::overrideType('jsonb', 'Boldtrn\JsonbBundle\Types\JsonbArrayType');
        } else {
            Type::addType('jsonb', 'Boldtrn\JsonbBundle\Types\JsonbArrayType');
        }

        $this->connection->getDatabasePlatform()->registerDoctrineTypeMapping('JSONB', 'jsonb');
    }

}
