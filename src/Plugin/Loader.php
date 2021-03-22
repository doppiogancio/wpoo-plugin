<?php

namespace WPOO\Plugin;

class Loader
{
    /**
     * @var array
     */
    private $actions;

    /**
     * @var array
     */
    protected $filters;

    public function __construct()
    {
        $this->actions = array();
        $this->filters = array();
    }

    public function addAction($hook, callable $callback, $priority = 10, $accepted_args = 1)
    {
        $this->actions[] = [
            'hook'          => $hook,
            'callback'      => $callback,
            'priority'      => $priority,
            'accepted_args' => $accepted_args
        ];
    }

    public function addFilter($hook, $callback, $priority = 10, $accepted_args = 1)
    {
        $this->filters[] = [
            'hook'          => $hook,
            'callback'      => $callback,
            'priority'      => $priority,
            'accepted_args' => $accepted_args
        ];
    }

    public function run()
    {
        foreach ($this->filters as $hook) {
            add_filter( $hook['hook'], $hook['callback'], $hook['priority'], $hook['accepted_args'] );
        }

        foreach ( $this->actions as $hook ) {
            add_action( $hook['hook'], $hook['callback'], $hook['priority'], $hook['accepted_args'] );
        }
    }
}