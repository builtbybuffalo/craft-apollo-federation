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
use craft\gql\types\generators\EntryType;
use craft\gql\interfaces\elements\Entry as EntryInterface;
use GraphQL\Type\Definition\UnionType;

class EntityUnion extends UnionType
{
    public static function getName(): string
    {
        return '_Entity';
    }

    public static function getType(): EntityUnion
    {
        if ($type = GqlEntityRegistry::getEntity(self::getName())) {
            return $type;
        }

        $unionTypes = array_values(EntryType::generateTypes());

        return GqlEntityRegistry::createEntity(self::getName(), new Self([
            'name' => self::getName(),
            'types' => $unionTypes,
            'resolveType' => EntryInterface::class . '::resolveElementTypeName',
        ]));
    }
}
