<?php
/**
 * Craft Apollo Federation plugin for Craft CMS 3.x
 *
 * Provides Apollo Federation support for Craft CMS.
 *
 * @link      https://builtbybuffalo.com/
 * @copyright Copyright (c) 2021 Built By Buffalo
 */

namespace builtbybuffalo\craftapollofederation;


use Craft;
use craft\base\Plugin;
use craft\services\Plugins;
use craft\services\Gql;
use craft\events\PluginEvent;
use craft\events\RegisterGqlQueriesEvent;

use yii\base\Event;

/**
 * Class CraftApolloFederation
 *
 * @author    Built By Buffalo
 * @package   CraftApolloFederation
 * @since     0.0.1
 *
 */
class CraftApolloFederation extends Plugin
{
    // Static Properties
    // =========================================================================

    /**
     * @var CraftApolloFederation
     */
    public static $plugin;

    // Public Properties
    // =========================================================================

    /**
     * @var string
     */
    public $schemaVersion = '0.0.1';

    /**
     * @var bool
     */
    public $hasCpSettings = false;

    /**
     * @var bool
     */
    public $hasCpSection = false;

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        self::$plugin = $this;

        Event::on(
            Plugins::class,
            Plugins::EVENT_AFTER_INSTALL_PLUGIN,
            function (PluginEvent $event) {
                if ($event->plugin === $this) {
                }
            }
        );

        Event::on(
            Gql::class,
            Gql::EVENT_REGISTER_GQL_QUERIES,
            function(RegisterGqlQueriesEvent $event) {
                $event->queries = array_merge($event->queries, queries\Federation::getQueries());
            }
        );

        Craft::info(
            Craft::t(
                'craft-apollo-federation',
                '{name} plugin loaded',
                ['name' => $this->name]
            ),
            __METHOD__
        );
    }

    // Protected Methods
    // =========================================================================

}
