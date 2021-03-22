<?php

namespace WPOO\Plugin\Twig;

use Twig\Environment;
use Twig\TwigFunction;
use function settings_fields;
use function do_settings_sections;
use function submit_button;
use function ob_start;

class WordpressFunctions
{
    static public function handleWordpressFunctions(Environment $twig)
    {
        $options = array('xis_safe' => array('html'));
        $twig->addFunction(new TwigFunction('settings_fields', function (string $optionGroup): string {
            return self::getOutput(function () use ($optionGroup) {
                settings_fields($optionGroup);
            });
        }, $options));

        $twig->addFunction(new TwigFunction('do_settings_sections', function (string $page): string {
            return self::getOutput(function () use ($page) {
                do_settings_sections($page);
            });
        }, $options));

        $twig->addFunction(new TwigFunction('submit_button', function (): string {
            return self::getOutput(function () {
                submit_button();
            });
        }, $options));
    }

    static private function getOutput(callable $callback): string
    {
        ob_start();
        $callback();
        return ob_get_clean();
    }
}