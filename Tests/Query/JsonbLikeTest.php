<?php
/**
 * Created by PhpStorm.
 * User: robin
 * Date: 14.04.15
 * Time: 14:11
 */

namespace Boldtrn\JsonbBundle\Tests\Query;


use Boldtrn\JsonbBundle\Tests\BaseTest;

class JsonbLikeTest extends BaseTest
{

    public function testContains()
    {
        $q = $this
            ->entityManager
            ->createQuery(
                "
        SELECT t
        FROM E:Test t
        WHERE JSONB_LIKE(t.attrs, '{\"object1\",\"object2\"}') LIKE '%a%'
        "
            );

        $this->assertEquals(
            "SELECT t0_.id AS id0, t0_.attrs AS attrs1 FROM Test t0_ WHERE (t0_.attrs #>> '{\"object1\",\"object2\"}') LIKE '%a%'",
            $q->getSql()
        );
    }

}
