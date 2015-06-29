<?php
/**
 * Created by PhpStorm.
 * User: robin
 * Date: 14.04.15
 * Time: 14:11
 */

namespace Boldtrn\JsonbBundle\Tests\Query;


use Boldtrn\JsonbBundle\Tests\BaseTest;

class JsonbExistenceTest extends BaseTest
{

    public function testContains()
    {
        $q = $this
            ->entityManager
            ->createQuery(
                "
        SELECT t
        FROM E:Test t
        WHERE JSONB_EX(t.attrs, 'value') = TRUE
        "
            );

        $expectedSQL = "SELECT t0.id AS id0, t0.attrs AS attrs1 FROM Test t0 WHERE (t0.attrs ? 'value') = true";

        $expectedSQL = str_replace("_", "", $expectedSQL);

        $actualSQL =  str_replace("_", "", $q->getSql());

        $this->assertEquals(
            $expectedSQL,
            $actualSQL
        );
    }

}
