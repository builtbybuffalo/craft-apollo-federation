<?php
/**
 * Craft Apollo Federation plugin for Craft CMS 3.x
 *
 * Provides Apollo Federation support for Craft CMS.
 *
 * @link      https://builtbybuffalo.com/
 * @copyright Copyright (c) 2021 Built By Buffalo
 */

namespace builtbybuffalo\craftapollofederation\utils;

use GraphQL\Type\Schema;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\Directive;
use GraphQL\Type\Definition\InterfaceType;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\FieldDefinition;
use GraphQL\Utils\SchemaPrinter;

class FederationSchemaPrinter extends SchemaPrinter
{
    public static function printFederationSdl(Schema $schema): string
    {
        $ignoredFederationTypes = ['_Any', '_Service', '_Entity'];

        return static::printFilteredSchema(
            $schema,
            function(Directive $directive): bool {
                // Filter out all directives
                return false;
            },
            function(Type $type) use ($ignoredFederationTypes): bool {
                return !Type::isBuiltInType($type) && !in_array($type->name, $ignoredFederationTypes);
            },
            []
        );
    }

    protected static function printInterface(InterfaceType $type, array $options): string
    {
        $directives = $type->name === 'EntryInterface' ? ' @key(fields: "id")' : '';

        return static::printDescription($options, $type) . sprintf(
            "interface %s%s {\n%s\n}",
            $type->name,
            $directives,
            static::printFields($options, $type)
        );
    }

    protected static function printObject(ObjectType $type, array $options): string
    {
        $interfaces = $type->getInterfaces();

        $interfaceNames = array_map(
            function(InterfaceType $interface): string {
                return $interface->name;
            },
            $interfaces
        );

        $implementedInterfaces = count($interfaces) > 0
            ? ' implements ' . implode(' & ', $interfaceNames)
            : '';

        $directives = in_array('EntryInterface', $interfaceNames) ? ' @key(fields: "id")' : '';

        return static::printDescription($options, $type) . sprintf(
            "type %s%s%s {\n%s\n}",
            $type->name,
            $implementedInterfaces,
            $directives,
            static::printFields($options, $type)
        );
    }

    protected static function printFields(array $options, $type): string
    {
        $fields = array_values($type->getFields());
        $ignoredFederationFields = ['_entities', '_service'];

        if ($type->name === 'Query') {
            $fields = array_filter($fields, function(FieldDefinition $f) use ($ignoredFederationFields) {
                return !in_array($f->name, $ignoredFederationFields);
            });
        }

        return implode(
            "\n",
            array_map(
                static function (FieldDefinition $f, int $i) use ($options): string {
                    return static::printDescription($options, $f, '  ', $i === 0) . '  ' .
                        $f->name . static::printArgs($options, $f->args, '  ') . ': ' .
                        (string) $f->getType() . static::printDeprecated($f);
                },
                $fields,
                array_keys($fields)
            )
        );
    }
}
