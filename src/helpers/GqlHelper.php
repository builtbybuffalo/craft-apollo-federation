<?php
/**
 * Craft Apollo Federation plugin for Craft CMS 3.x
 *
 * Provides Apollo Federation support for Craft CMS.
 *
 * @link      https://builtbybuffalo.com/
 * @copyright Copyright (c) 2021 Built By Buffalo
 */

namespace builtbybuffalo\craftapollofederation\helpers;

use craft\models\GqlSchema;
use craft\helpers\Gql as BaseHelper;

class GqlHelper extends BaseHelper
{
    public static function canUseFederation(?GqlSchema $schema = null): bool
    {
        $allowedEntities = self::extractAllowedEntitiesFromSchema('read', $schema);

        return array_key_exists('federation', $allowedEntities) && $allowedEntities['federation'];
    }
}
