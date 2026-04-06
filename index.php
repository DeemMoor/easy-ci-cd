<?php

declare(strict_types=1);

/**
 * Application entry point
 */
final class Application
{
    public function run(): void
    {
        echo "Hello, world!";
    }
}

new Application()->run();