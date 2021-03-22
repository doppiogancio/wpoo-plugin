<?php

namespace WPOO\Plugin\Shortcode;

use Twig\Environment;

class DemoTemplate implements Shortcode
{
    /**
     * @var Environment
     */
    private $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    public function getName(): string
    {
        return 'demo_template';
    }

    public function render(): string
    {
        global $post;
        return $this->twig->render('demo_template.html.twig', [
            'post' => $post,
            'words' => [
                'lorem', 'ipsum', 'sit', 'amet'
            ]
        ]);
    }
}