<?php
/**
 * Craft Apollo Federation plugin for Craft CMS 3.x
 *
 * Provides Apollo Federation support for Craft CMS.
 *
 * @link      https://builtbybuffalo.com/
 * @copyright Copyright (c) 2021 Built By Buffalo
 */

namespace builtbybuffalo\craftapollofederation\resolvers;

use Craft;
use GraphQL\Type\Definition\ResolveInfo;

use builtbybuffalo\craftapollofederation\utils\FederationSchemaPrinter;

class ServiceResolver
{
    public static function resolve($source, array $arguments, $context, ResolveInfo $resolveInfo)
    {
        $schema = Craft::$app->gql->getActiveSchema();
        $schemaDef = Craft::$app->gql->getSchemaDef($schema, true);

        $sdl = FederationSchemaPrinter::printFederationSdl($schemaDef);

        return ['sdl' => $sdl];
    }
}
