<?php
/**
 * Craft Apollo Federation plugin for Craft CMS 3.x
 *
 * Provides Apollo Federation support for Craft CMS.
 *
 * @link      https://builtbybuffalo.com/
 * @copyright Copyright (c) 2021 Built By Buffalo
 */

namespace builtbybuffalo\craftapollofederation\queries;

use craft\gql\base\Query;
use GraphQL\Type\Definition\Type;

use builtbybuffalo\craftapollofederation\types\ServiceType;
use builtbybuffalo\craftapollofederation\types\AnyType;
use builtbybuffalo\craftapollofederation\types\EntityUnion;
use builtbybuffalo\craftapollofederation\resolvers\ServiceResolver;
use builtbybuffalo\craftapollofederation\resolvers\EntityResolver;

class Federation extends Query
{
    public static function getQueries($checkToken = true): array
    {
        // TODO: Possibly make use of $checkToken here

        return [
            '_service' => [
                'type' => Type::nonNull(ServiceType::getType()),
                'resolve' => ServiceResolver::class . '::resolve',
            ],

            '_entities' => [
                'type' => Type::nonNull(Type::listOf(EntityUnion::getType())),
                'args' => [
                    'representations' => Type::nonNull(Type::listOf(Type::nonNull(AnyType::getType()))),
                ],
                'resolve' => EntityResolver::class . '::resolve',
            ],
        ];
    }
}
