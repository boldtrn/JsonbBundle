<?php

namespace Boldtrn\JsonbBundle\Tests\Query;


use Boldtrn\JsonbBundle\Tests\BaseTest;

class JsonbExistenceAnyTest extends BaseTest
{

    public function testExistence()
    {
        $q = $this
            ->entityManager
            ->createQuery(
                "
        SELECT t
        FROM E:Test t
        WHERE JSONB_EX_ANY(t.attrs, 'value') = TRUE
        "
            );

        $expectedSQL = "SELECT t0.id AS id0, t0.attrs AS attrs1 FROM Test t0 WHERE jsonb_exists_any(t0.attrs, ARRAY['value']) = true";

        $expectedSQL = str_replace("_", "", $expectedSQL);

        $actualSQL =  str_replace("_", "", $q->getSql());

        $this->assertEquals(
            $expectedSQL,
            $actualSQL
        );
    }

}
