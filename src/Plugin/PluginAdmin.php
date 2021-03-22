<?php

namespace WPOO\Plugin;

use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;
use WPOO\Plugin\Twig\WordpressFunctions;

class PluginAdmin
{
    /**
     * @var Plugin
     */
    protected $plugin;

    /**
     * @var Environment
     */
    protected $twig;

    public function __construct(Plugin $plugin)
    {
        $this->plugin = $plugin;

        $loader = new FilesystemLoader($this->getAbsolutePath('partials'));
        $this->twig = new Environment(
            $loader, [
            'debug' => true,
            'cache' => $this->getAbsolutePath('cache'),
            ]
        );

        WordpressFunctions::handleWordpressFunctions($this->twig);
        $this->twig->addExtension(new DebugExtension());
    }

    public function enqueueStyles()
    {
        wp_enqueue_style($this->getName(), $this->getAbsoluteUrl('css/plugin-admin.css'), array(), $this->plugin->getVersion(), 'all');
    }

    public function enqueueScripts()
    {
        wp_enqueue_script($this->getName(), $this->getAbsoluteUrl('js/plugin-admin.js'), array( 'jquery' ), $this->plugin->getVersion(), false);
    }

    private function getAbsolutePath(string $path): string
    {
        return $this->plugin->getAbsolutePath('admin/' . $path);
    }

    private function getAbsoluteUrl(string $path): string
    {
        return $this->plugin->getAbsoluteUrl('admin/' . $path);
    }

    private function getRelativePath(string $path): string
    {
        return $this->plugin->getAbsolutePath('admin/' . $path);
    }

    private function getRelativeUrl(string $path): string
    {
        return $this->plugin->getAbsoluteUrl('admin/' . $path);
    }

    private function getName(): string
    {
        return $this->plugin->getName() . '-admin';
    }
}