<?php

namespace WPOO\Plugin\Rest\Router;

use WP_REST_Server;

class Group implements EngineInterface
{
    private EngineInterface $engine;
    private string $relativePath;

    public function __construct(EngineInterface $engine, string $relativePath)
    {
        $this->engine = $engine;
        $this->relativePath = $relativePath;
    }

    public function group(string $relativePath): Group
    {
        return new Group($this, $relativePath);
    }

    public function GET(string $route, callable $callback)
    {
        register_rest_route(
            $this->getRelativePath(), $route, [
            [
                'methods' => WP_REST_Server::READABLE,
                'callback' => $callback,
                'permission_callback' => '__return_true',
            ],
            ]
        );
    }

    public function POST(string $route, callable $callback)
    {
        register_rest_route(
            $this->getRelativePath(), $route, [
            [
                'methods' => WP_REST_Server::CREATABLE,
                'callback' => $callback,
                'permission_callback' => '__return_true',
            ],
            ]
        );
    }

    public function PUT(string $route, callable $callback)
    {
        register_rest_route(
            $this->getRelativePath(), $route, [
            [
                'methods' => 'PUT',
                'callback' => $callback,
                'permission_callback' => '__return_true',
            ],
            ]
        );
    }

    public function DELETE(string $route, callable $callback)
    {
        register_rest_route(
            $this->getRelativePath(), $route, [
            [
                'methods' => WP_REST_Server::DELETABLE,
                'callback' => $callback,
                'permission_callback' => '__return_true',
            ],
            ]
        );
    }

    public function getRelativePath(string $relativePath = ''): string
    {
        return $this->engine->getRelativePath($this->relativePath);
    }
}