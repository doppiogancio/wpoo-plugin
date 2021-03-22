<?php

namespace WPOO\Plugin\Shortcode;

interface Shortcode
{
    public function getName(): string;
    public function render(): string;
}