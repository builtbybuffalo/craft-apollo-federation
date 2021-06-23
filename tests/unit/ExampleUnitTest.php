<?php
/**
 * Craft Apollo Federation plugin for Craft CMS 3.x
 *
 * Provides Apollo Federation support for Craft CMS.

Currently only really a work in progress / proof of concept.
 *
 * @link      https://builtbybuffalo.com/
 * @copyright Copyright (c) 2021 Built By Buffalo
 */

namespace builtbybuffalo\craftapollofederationtests\unit;

use Codeception\Test\Unit;
use UnitTester;
use Craft;
use builtbybuffalo\craftapollofederation\CraftApolloFederation;

/**
 * ExampleUnitTest
 *
 *
 * @author    Built By Buffalo
 * @package   CraftApolloFederation
 * @since     0.0.1
 */
class ExampleUnitTest extends Unit
{
    // Properties
    // =========================================================================

    /**
     * @var UnitTester
     */
    protected $tester;

    // Public methods
    // =========================================================================

    // Tests
    // =========================================================================

    /**
     *
     */
    public function testPluginInstance()
    {
        $this->assertInstanceOf(
            CraftApolloFederation::class,
            CraftApolloFederation::$plugin
        );
    }

    /**
     *
     */
    public function testCraftEdition()
    {
        Craft::$app->setEdition(Craft::Pro);

        $this->assertSame(
            Craft::Pro,
            Craft::$app->getEdition()
        );
    }
}
