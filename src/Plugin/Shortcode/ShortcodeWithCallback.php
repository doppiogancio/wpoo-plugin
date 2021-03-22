<?php


namespace WPOO\Plugin\Shortcode;


class ShortcodeWithCallback implements Shortcode
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var callable
     */
    private $callback;

    public function __construct(string $name, callable $callback)
    {
        $this->name = $name;
        $this->callback = $callback;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function render(): string
    {
        return call_user_func($this->callback);
    }
}