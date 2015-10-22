<?php

namespace Boldtrn\JsonbBundle\Tests\Entities;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;

/**
 * @Entity()
 */
class Test
{

    /**
     * @Id
     * @Column(type="string")
     * @GeneratedValue
     */
    protected $id;

    /**
     * @Column(type="jsonb")
     */
    protected $attrs = array();

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getAttrs()
    {
        return $this->attrs;
    }

    /**
     * @param mixed $attrs
     */
    public function setAttrs($attrs)
    {
        $this->attrs = $attrs;
    }

}