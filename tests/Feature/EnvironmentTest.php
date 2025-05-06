<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EnvironmentTest extends TestCase
{
    /**
     * Test membaca nilai environment variable.
     */
    public function test_example(): void
    {
    }

    /**
     * Test nilai default environment variable.
     */
    public function testDefaultValue(): void
    {
        $author = env("AUTHOR", "Eko");
        self::assertEquals("Eko", $author);
    }
}
