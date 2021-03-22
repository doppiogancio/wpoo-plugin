<?php

namespace WPOO\Plugin;


class Hook
{
    private $hook;
    private $component;
    private $callback;
    private $priority = 10;
    private $acceptedArgs = 1;

    /**
     * Hook constructor.
     * @param string $hook
     * @param $component
     * @param string $callback
     * @param int $priority
     * @param int $acceptedArgs
     */
    public function __construct(string $hook, $component, string $callback, int $priority = 10, int $acceptedArgs = 1)
    {
        $this->hook = $hook;
        $this->component = $component;
        $this->callback = $callback;
        $this->priority = $priority;
        $this->acceptedArgs = $acceptedArgs;
    }

    /**
     * @return string
     */
    public function getHook(): string
    {
        return $this->hook;
    }

    /**
     * @return mixed
     */
    public function getComponent()
    {
        return $this->component;
    }

    /**
     * @return string
     */
    public function getCallback(): string
    {
        return $this->callback;
    }

    /**
     * @return int
     */
    public function getPriority(): int
    {
        return $this->priority;
    }

    /**
     * @return int
     */
    public function getAcceptedArgs(): int
    {
        return $this->acceptedArgs;
    }
}