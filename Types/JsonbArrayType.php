<?php
namespace Boldtrn\JsonbBundle\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\JsonArrayType;

/**
 * Array Type which can be used to generate jsonb arrays. It uses the Doctrine JsonArrayType
 *
 * @author Robin Boldt <boldtrn@gmail.com>
 */
class JsonbArrayType extends JsonArrayType
{
    /**
     * {@inheritdoc}
     */
    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return 'JSONB';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'jsonb';
    }

}
