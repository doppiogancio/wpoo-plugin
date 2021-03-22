<?php

namespace WPOO\XmlTransformer;

use WPOO\Plugin\Plugin as BasePlugin;

class Plugin extends BasePlugin
{
    protected function defineAdminHooks(): void
    {
        parent::defineAdminHooks();

        $pluginAdmin = new PluginAdmin($this);

        $this->loader->addAction(
            'wp_ajax_nopriv_start_script',
            [$pluginAdmin, 'startXmlTransformScript']
        );

        $this->loader->addAction(
            'wp_ajax_start_script',
            [$pluginAdmin, 'startXmlTransformScript']
        );

        // Add admin page
        $this->loader->addAction(
            'admin_menu',
            static function () use ($pluginAdmin) {
                add_menu_page(
                    'XML Transformer',
                    'XML Transformer',
                    'manage_options',
                    'xml-transformer',
                    [$pluginAdmin, 'renderAdminMenuPage']
                );
            }
        );

        $this->loader->addAction(
            'admin_init',
            static function () use ($pluginAdmin) {
                $pluginAdmin->registerSetting();
            }
        );
    }
}
