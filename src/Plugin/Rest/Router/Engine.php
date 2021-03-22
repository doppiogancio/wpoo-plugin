<?php

namespace WPOO\Plugin\Rest\Router;

use WP_REST_Server;

class Engine implements EngineInterface
{
    private string $relativePath;

    public function __construct(string $relativePath)
    {
        $this->relativePath = $relativePath;
    }

    public function group(string $relativePath): Group
    {
        return new Group($this, $relativePath);
    }

    public function GET(string $route, callable $callback)
    {
        register_rest_route($this->getRelativePath(), $route, [
            [
                'methods' => WP_REST_Server::READABLE,
                'callback' => $callback,
                'permission_callback' => '__return_true',
            ],
        ]);
    }

    public function POST(string $route, callable $callback)
    {
        register_rest_route($this->getRelativePath(), $route, [
            [
                'methods' => WP_REST_Server::CREATABLE,
                'callback' => $callback,
                'permission_callback' => '__return_true',
            ],
        ]);
    }

    public function PUT(string $route, callable $callback)
    {
        register_rest_route($this->getRelativePath(), $route, [
            [
                'methods' => 'PUT',
                'callback' => $callback,
                'permission_callback' => '__return_true',
            ],
        ]);
    }

    public function DELETE(string $route, callable $callback)
    {
        register_rest_route($this->getRelativePath(), $route, [
            [
                'methods' => WP_REST_Server::DELETABLE,
                'callback' => $callback,
                'permission_callback' => '__return_true',
            ],
        ]);
    }

    public function getRelativePath(string $relativePath = ''): string
    {
        return $this->relativePath . $relativePath;
    }
}