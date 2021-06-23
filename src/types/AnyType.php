<?php
/**
 * Craft Apollo Federation plugin for Craft CMS 3.x
 *
 * Provides Apollo Federation support for Craft CMS.
 *
 * @link      https://builtbybuffalo.com/
 * @copyright Copyright (c) 2021 Built By Buffalo
 */

namespace builtbybuffalo\craftapollofederation\types;

use craft\gql\GqlEntityRegistry;
use GraphQL\Type\Definition\ScalarType;

class AnyType extends ScalarType
{
    public $name = '_Any';

    public static function getName(): string
    {
        return '_Any';
    }

    public static function getType(): AnyType
    {
        if ($type = GqlEntityRegistry::getEntity(self::getName())) {
            return $type;
        }

        return GqlEntityRegistry::createEntity(self::getName(), new Self());
    }

    public function serialize($value)
    {
        return $value;
    }

    public function parseValue($value)
    {
        return $value;
    }

    public function parseLiteral($valueNode, array $variables = null)
    {
        return $valueNode->value;
    }
}
