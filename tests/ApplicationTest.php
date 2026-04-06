<?php

declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\TestCase;

class ApplicationTest extends TestCase
{
    public static function setUpBeforeClass(): void
    {
        ob_start();
        require_once __DIR__ . '/../index.php';
        ob_end_clean();
    }

    public function testRunOutputsHelloWorld(): void
    {
        $app = new \Application();

        ob_start();
        $app->run();
        $output = ob_get_clean();

        $this->assertSame('Hello, world!', $output);
    }
}