<?php

namespace WPOO\Plugin;

use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;
use WPOO\Plugin\Rest\Controller\V1\UserController;
use WPOO\Plugin\Rest\Controller\V2\PhotoController;
use WPOO\Plugin\Rest\Router\EngineInterface;
use WPOO\Plugin\Shortcode\DemoTemplate;
use WPOO\Plugin\Shortcode\ShortcodeWithCallback;

class PluginPublic
{
    /**
     * @var Plugin
     */
    private $plugin;

    /**
     * @var Environment
     */
    private $twig;

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

        $this->twig->addExtension(new DebugExtension());
    }

    public function enqueueStyles()
    {
        wp_enqueue_style($this->getName(), $this->getAbsoluteUrl('css/plugin-public.css'), array(), $this->plugin->getVersion(), 'all');
    }

    public function enqueueScripts()
    {
        wp_enqueue_script($this->getName(), $this->getAbsoluteUrl('js/plugin-public.js'), array( 'jquery' ), $this->plugin->getVersion(), false);
    }

    public function decorateTitles($title, $id = null): string
    {
        return $title . '444';
    }

    private function getAbsolutePath(string $path): string
    {
        return $this->plugin->getAbsolutePath('public/' . $path);
    }

    private function getAbsoluteUrl(string $path): string
    {
        return $this->plugin->getAbsoluteUrl('public/' . $path);
    }

    private function getName(): string
    {
        return $this->plugin->getName() . '-public';
    }

    /**
     * @return Shortcode\Shortcode[]
     */
    public function getShortcodes(): array
    {
        return [
            new DemoTemplate($this->twig),
            new ShortcodeWithCallback(
                'test', static function (): string {
                    return 'Just a test';
                }
            ),
        ];
    }

    public function getV1Controllers(EngineInterface $engine): array
    {
        return [
            new UserController($engine)
        ];
    }

    public function getV2Controllers(EngineInterface $engine): array
    {
        return [
            new PhotoController($engine)
        ];
    }
}
