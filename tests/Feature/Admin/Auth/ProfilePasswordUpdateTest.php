<?php

namespace Tests\Feature\Admin\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\Concerns\ActsAsAdmin;
use Tests\TestCase;

class ProfilePasswordUpdateTest extends TestCase
{
    use RefreshDatabase;
    use ActsAsAdmin;

    public function test_edit_form_renders_for_a_user_with_the_permission(): void
    {
        $this->actingAsAdmin();

        $this->get(route('profile.password.edit'))->assertOk();
    }

    public function test_edit_form_is_forbidden_without_authentication(): void
    {
        $this->get(route('profile.password.edit'))->assertRedirect(route('login'));
    }

    public function test_updates_the_password_when_valid(): void
    {
        $admin = $this->actingAsAdmin();

        $response = $this->post(route('profile.password.update'), [
            'password' => 'new-secret-password',
            'password_confirmation' => 'new-secret-password',
        ]);

        $response->assertRedirect(route('profile.password.edit'));
        $this->assertTrue(Hash::check('new-secret-password', $admin->fresh()->getRawOriginal('password')));
    }

    public function test_rejects_a_password_shorter_than_8_characters(): void
    {
        $this->actingAsAdmin();

        $response = $this->post(route('profile.password.update'), [
            'password' => 'short',
            'password_confirmation' => 'short',
        ]);

        $response->assertSessionHasErrors('password');
    }

    public function test_rejects_a_mismatched_confirmation(): void
    {
        $this->actingAsAdmin();

        $response = $this->post(route('profile.password.update'), [
            'password' => 'new-secret-password',
            'password_confirmation' => 'different-password',
        ]);

        $response->assertSessionHasErrors('password');
    }
}
