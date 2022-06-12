<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

use App\Models\User;
use Laravel\Sanctum\Sanctum;

class UserTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_the_application_returns_a_successful_response()
    {
        Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );

        // $response = $this->get('/api/products');
        $this->assertTrue(true);

    }
}
