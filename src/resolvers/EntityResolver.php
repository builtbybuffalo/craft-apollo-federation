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
        $requestedIds = array_column($arguments['representations'], 'id');
        $searchIds = array_unique(array_filter($requestedIds));

        $entries = EntryResolver::resolve(
            null,
            ['id' => $searchIds],
            $context,
            $resolveInfo
        );

        $entriesById = [];

        foreach ($entries as $entry) {
            if (!empty($entry->id)) {
                $entriesById[$entry->id] = $entry;
            }
        }

        return array_map(
            function($requestedId) use ($entriesById) {
                if (empty($requestedId) || !array_key_exists($requestedId, $entriesById)) {
                    return null;
                }

                return $entriesById[$requestedId];
            },
            $requestedIds
        );
    }
}
