<?php

namespace Boldtrn\JsonbBundle\Tests\Entities;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;

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
     */
    public $attrs;

}