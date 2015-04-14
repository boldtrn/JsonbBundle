<?php
/**
 * Created by PhpStorm.
 * User: robin
 * Date: 14.04.15
 * Time: 14:11
 */

namespace Boldtrn\JsonbBundle\Tests\Query;


use Boldtrn\JsonbBundle\Tests\BaseTest;

class JsonbContainsTest extends BaseTest
{

    public function testContains()
    {
        $q = $this
            ->entityManager
            ->createQuery(
                "
        SELECT t
        FROM E:Test t
        WHERE JSONB_CONTAINS(t.attrs, 'value') = TRUE
        "
            );

        $this->assertEquals(
            "SELECT t0_.id AS id0, t0_.attrs AS attrs1 FROM Test t0_ WHERE (t0_.attrs @> 'value') = true",
            $q->getSql()
        );
    }

}
