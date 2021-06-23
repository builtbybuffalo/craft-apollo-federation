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

use craft\gql\resolvers\elements\Entry as EntryResolver;
use GraphQL\Type\Definition\ResolveInfo;

class EntityResolver
{
    public static function resolve($source, array $arguments, $context, ResolveInfo $resolveInfo)
    {
        return array_map(
            function($representation) use ($context, $resolveInfo) {
                return EntryResolver::resolveOne(
                    null,
                    ['id' => $representation['id']],
                    $context,
                    $resolveInfo
                );
            },
            $arguments['representations']
        );
    }
}
