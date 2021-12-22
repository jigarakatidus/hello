<?php

namespace Tests\Feature;

use App\Models\Hello;
use http\Client\Curl\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class HelloTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_list_hellos()
    {
        Sanctum::actingAs(\App\Models\User::factory()->create(), ['*']);
        $response = $this->get('/api/hello');
        $response->assertStatus(200);
    }

    /** @test */
    public function can_add_hello()
    {
        Sanctum::actingAs(\App\Models\User::factory()->create(), ['*']);

        $response = $this->post('/api/hello', ['name' => 'Jigar Test']);

        $response->assertStatus(201);
    }

    /** @test */
    public function can_add_trashed_hello()
    {
        Sanctum::actingAs(\App\Models\User::factory()->create(), ['*']);

        $hello = Hello::factory()->create();

        $response = $this->post('/api/hello', ['name' => $hello->name]);

        $response->assertStatus(200);
    }

    /** @test */
    public function can_update_hello()
    {
        Sanctum::actingAs(\App\Models\User::factory()->create(), ['*']);

        $hello = Hello::factory()->create();

        $response = $this->put('/api/hello/' . $hello->id, ['name' => 'New Name']);

        $response->assertStatus(200);
    }

    /** @test */
    public function can_delete_hello()
    {
        Sanctum::actingAs(\App\Models\User::factory()->create(), ['*']);

        $hello = Hello::factory()->create();
        $response = $this->delete('/api/hello/' . $hello->id);

        $response->assertStatus(200);
    }
}
