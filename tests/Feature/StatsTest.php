<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Laravel\Sanctum\Sanctum;


class StatsTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_peut_acceder_aux_stats()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        Sanctum::actingAs($admin);

        $response = $this->getJson('/api/admin/bornes/stats');

        $response->assertStatus(200);
    }

    public function test_user_ne_peut_pas_acceder_aux_stats()
    {
        $user = User::factory()->create(['role' => 'user']);
        Sanctum::actingAs($user);

        $response = $this->getJson('/api/admin/bornes/stats');

        $response->assertStatus(403);
    }
}
