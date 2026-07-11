<?php

namespace Tests\Feature\Admin\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Concerns\ActsAsAdmin;
use Tests\TestCase;

class ProfileUpdateTest extends TestCase
{
    use RefreshDatabase;
    use ActsAsAdmin;

    public function test_updates_name_and_email(): void
    {
        $admin = $this->actingAsAdmin();

        $response = $this->post(route('profile.password.updateProfile'), [
            'name' => 'Novo Nome',
            'email' => 'novo@email.com',
        ]);

        $response->assertRedirect(route('profile.password.edit'));
        $this->assertDatabaseHas('users', ['id' => $admin->id, 'name' => 'Novo Nome', 'email' => 'novo@email.com']);
    }

    public function test_email_must_be_unique_excluding_the_current_user(): void
    {
        $admin = $this->actingAsAdmin();
        $other = User::factory()->create(['email' => 'ocupado@email.com']);

        $response = $this->post(route('profile.password.updateProfile'), [
            'name' => $admin->name,
            'email' => 'ocupado@email.com',
        ]);

        $response->assertSessionHasErrors('email');
    }

    public function test_can_keep_the_same_email_when_updating_only_the_name(): void
    {
        $admin = $this->actingAsAdmin();

        $response = $this->post(route('profile.password.updateProfile'), [
            'name' => 'Outro Nome',
            'email' => $admin->email,
        ]);

        $response->assertRedirect(route('profile.password.edit'));
        $response->assertSessionMissing('errors');
    }
}
