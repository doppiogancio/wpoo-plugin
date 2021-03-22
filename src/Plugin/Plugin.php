<?php

namespace WPOO\Plugin;

use WPOO\Plugin\Rest\Router\Engine;

class Plugin
{
    /**
     * @var Loader
     */
    protected $loader;

    /**
     * The unique identifier of this plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $plugin_name    The string used to uniquely identify this plugin.
     */
    protected $name;

    /**
     * The current version of the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $version    The current version of the plugin.
     */
    protected $version;

    public function __construct(string $name, string $version)
    {
        $this->name = $name;
        $this->version = $version;

        $this->loadDependencies();
        $this->setLocale();
        $this->defineAdminHooks();
        $this->definePublicHooks();
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getVersion(): string
    {
        return $this->version;
    }

    public function getAbsolutePath(string $path): string
    {
        return WPOO_PLUGIN_DIR . $path;
    }

    public function getAbsoluteUrl(string $path): string
    {
        return WPOO_PLUGIN_URL . $path;
    }

    public function getRelativePath(string $path): string
    {
        return $path;
    }

    public function getRelativeUrl(string $path): string
    {
        return $path;
    }

    public function run()
    {
        $this->loader->run();
    }

    protected function loadDependencies()
    {
        $this->loader = new Loader();
    }

    protected function setLocale()
    {
        $locale = new Locale('demo');
        $this->loader->addAction('plugins_loaded', [$locale, 'loadPluginTextDomain']);
    }

    protected function defineAdminHooks()
    {
        $pluginAdmin = $this->getPluginAdmin();
        $this->loader->addAction( 'admin_enqueue_scripts', [$pluginAdmin, 'enqueueStyles']);
        $this->loader->addAction( 'admin_enqueue_scripts', [$pluginAdmin, 'enqueueScripts']);
    }

    protected function definePublicHooks()
    {
        $pluginPublic = new PluginPublic($this);
        $this->loader->addAction( 'wp_enqueue_scripts', [$pluginPublic, 'enqueueStyles']);
        $this->loader->addAction( 'wp_enqueue_scripts', [$pluginPublic, 'enqueueScripts']);

        // Here we add filters and actions
        $this->loader->addFilter('the_title', [$pluginPublic, 'decorateTitles'], 10, 2);

        // Shortcodes
        foreach ($pluginPublic->getShortcodes() as $shortcode) {
            add_shortcode($shortcode->getName(), [$shortcode, 'render']);
        }

        add_action('rest_api_init', static function () use ($pluginPublic) {
            $engine = new Engine('wpoo');

            $v1 = $engine->group('/v1');
            $v2 = $engine->group('/v2');

            foreach ($pluginPublic->getV1Controllers($v1) as $controller) {
                $controller->registerRoutes();
            }

            foreach ($pluginPublic->getV2Controllers($v2) as $controller) {
                $controller->registerRoutes();
            }
        });
    }

    protected function getPluginAdmin(): PluginAdmin
    {
        return new PluginAdmin($this);
    }

    protected function getPluginPublic(): PluginPublic
    {
        return new PluginPublic($this);
    }
}