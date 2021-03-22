<?php

namespace WPOO\XmlTransformer;

use WPOO\Plugin\PluginAdmin as BasePluginAdmin;

use function register_setting;
use function add_settings_section;
use function add_settings_field;
use function html_entity_decode;

class PluginAdmin extends BasePluginAdmin
{
    const PAGE = 'xml-transformer';
    const OPTION_GROUP = 'xml_transformer_option_group';
    const OPTION_NAME = 'xml_transformer_settings';
    const SECTION_ID = 'setting_section_id';

    public function startXmlTransformScript(): void
    {
        // Request URL:
        // http://localhost:8081/wp-admin/admin-ajax.php?action=start_script
        sleep(1);
        echo "xxx";
        wp_die();
    }

    public function renderAdminMenuPage(): void
    {
        $html = $this->twig->render('plugin-admin-menu-page.html.twig', [
            'title' => 'XML Transformer',
            'optionGroup' => self::OPTION_GROUP,
            'page' => self::PAGE,
        ]);

        print html_entity_decode($html);
    }

    public function registerSetting(): void
    {
        register_setting(
            self::OPTION_GROUP,
            self::OPTION_NAME,
            function ($input) {
                $newInput = [];

                foreach ($input as $name => $value) {
                    if (in_array($name, ['xml_source_path', 'xml_destination_path', 'xml_destination_file_name'])) {
                        $newInput[$name] = sanitize_text_field($input[$name]);
                    }
                }

                return $newInput;
            }
        );

        add_settings_section(
            self::SECTION_ID,
            'Settings',
            function () {
                echo "<pre>";
                print_r(get_option(self::OPTION_NAME));
                echo "</pre>";
            },
            self::PAGE
        );

        $this->addSettingsField(
            self::PAGE,
            self::SECTION_ID,
            'XML Source Path',
            'xml_source_path'
        );

        $this->addSettingsField(
            self::PAGE,
            self::SECTION_ID,
            'XML Destination Path',
            'xml_destination_path'
        );

        $this->addSettingsField(
            self::PAGE,
            self::SECTION_ID,
            'XML Destination File Name',
            'xml_destination_file_name'
        );
    }

    private function addSettingsField(string $page, string $section, string $fieldName, string $fieldId): void
    {
        add_settings_field(
            $fieldId,
            $fieldName,
            function () use ($fieldId) {
                $options = get_option(self::OPTION_NAME);
                print $this->twig->render('text-field.html.twig', [
                    'title' => $fieldId,
                    'optionName' => self::OPTION_NAME,
                    'fieldName' => $fieldId,
                    'value' => isset($options[$fieldId]) ? esc_attr($options[$fieldId]) : '',
                ]);
            },
            $page,
            $section
        );
    }
}