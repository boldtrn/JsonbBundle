<?php
/**
 * Created by PhpStorm.
 * User: robin
 * Date: 14.04.15
 * Time: 14:11
 */

namespace Boldtrn\JsonbBundle\Tests\IntegrationTest;

use Boldtrn\JsonbBundle\Tests\BaseTest;
use Boldtrn\JsonbBundle\Tests\Entities\Test;

class IntegrationTest extends BaseTest
{


    public function testSimpleInsertSelect()
    {

        $test = new Test();
        $test->setAttrs(array('foo' => 'bar'));

        $this->entityManager->persist($test);
        $this->entityManager->flush();

        /** @var Test $retrievedTest */
        $retrievedTest = $this->entityManager->getRepository($this->testEntityName)->find($test->getId());

        static::assertEquals($test->getAttrs(), $retrievedTest->getAttrs());

    }

}
