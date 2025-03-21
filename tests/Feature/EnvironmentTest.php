<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EnvironmentTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $appName = env ("YOUTUBE");
        self::assertEquols("programer", $appName);
        // $response = $this->get('/');
        // $response->assertStatus(200);
    }
    public function testDefaultValue()
{
    $author = env("AUTHOR", "Eko");
    self::assertEquols("Eko", $author);
}


    
}
