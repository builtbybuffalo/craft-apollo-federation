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
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ObjectType;

class ServiceType extends ObjectType
{
    public $name = '_Service';

    public static function getName(): string
    {
        return '_Service';
    }

    public static function getType(): ServiceType
    {
        if ($type = GqlEntityRegistry::getEntity(self::getName())) {
            return $type;
        }

        return GqlEntityRegistry::createEntity(self::getName(), new Self([
            'name' => self::getName(),
            'fields' => [
                'sdl' => ['type' => Type::string()],
            ],
        ]));
    }
}
