<?php

namespace WPOO\Plugin\Rest\Router;

interface EngineInterface
{
    public function group(string $relativePath): Group;
    public function getRelativePath(string $relativePath = ''): string;
    public function GET(string $route, callable $callback);
    public function POST(string $route, callable $callback);
    public function PUT(string $route, callable $callback);
    public function DELETE(string $route, callable $callback);
    // TODO define permission callback using USE middleware
}