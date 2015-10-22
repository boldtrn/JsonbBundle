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

        $test = $this->createTest(array('foo' => 'bar'));

        /** @var Test $retrievedTest */
        $retrievedTest = $this->entityManager->getRepository($this->testEntityName)->find($test->getId());

        static::assertEquals($test->getAttrs(), $retrievedTest->getAttrs());

    }

    public function testEmptyArray()
    {

        $test = $this->createTest(array());

        /** @var Test $retrievedTest */
        $retrievedTest = $this->entityManager->getRepository($this->testEntityName)->find($test->getId());

        static::assertEquals($test->getAttrs(), $retrievedTest->getAttrs());

    }

    /**
     * @param $attrs array the attributes of the jsonb array
     * @return Test
     */
    private function createTest($attrs)
    {
        $test = new Test();
        $test->setAttrs($attrs);

        $this->entityManager->persist($test);
        $this->entityManager->flush();

        return $test;
    }

    private function clearTable()
    {

        foreach ($this->entityManager->getRepository($this->testEntityName)->findAll() as $test) {
            $this->entityManager->remove($test);
        }

        $this->entityManager->flush();

    }

}
