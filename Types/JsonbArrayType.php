<?php
namespace Boldtrn\JsonbBundle\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\JsonType;

/**
 * Array Type which can be used to generate jsonb arrays. It uses the Doctrine JsonArrayType
 *
 * @author Robin Boldt <boldtrn@gmail.com>
 */
class JsonbArrayType extends JsonType
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

    /**
     * {@inheritdoc}
     */
    public function requiresSQLCommentHint(AbstractPlatform $platform)
    {
        return true;
    }

}
