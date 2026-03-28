<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Borne;
use Laravel\Sanctum\Sanctum;

class ReservationTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_peut_reserver_borne()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $borne = Borne::factory()->create();

        $response = $this->postJson('/api/reservations', [
            'borne_id' => $borne->id,
            'date_debut' => now()->addMinutes(5),
            'duree_minutes' => 60
        ]);

        $response->assertStatus(201);
    }
}
