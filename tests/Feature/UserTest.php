<?php

namespace Tests\Feature;

use App\Http\Middleware\PurchaseStatus;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutMiddleware([
            PurchaseStatus::class,
        ]);

        $this->user = User::factory()->create();
    }


    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_an_authenticated_user_can_view_the_homepage(): void
    {
        $this->actingAs($this->user);

        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /**
     * @return void
     */
    public function test_an_user_can_update_their_profile(): void
    {
        $this->actingAs($this->user);

        $response = $this->patch(route('users.update', $this->user));

        $response->assertStatus(302);
    }

    public function test_an_user_cannot_see_other_users_edit_profile_page()
    {
        $newUser = User::factory()->create();

        $this->actingAs($newUser);

        $response = $this->get(route('users.edit', $this->user));

        $response->assertStatus(403);
    }
}
