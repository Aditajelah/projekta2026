<?php

namespace Tests\Feature;

use App\Notifications\AdminResetPasswordNotification;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class AdminUserPasswordResetTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_reset_user_password(): void
    {
        Notification::fake();

        $admin = User::factory()->create(['role' => 'admin']);
        $member = User::factory()->create([
            'role' => 'member',
            'password' => Hash::make('old-password-123'),
        ]);

        $response = $this->actingAs($admin)->post(route('admin.users.reset-password', $member), [
            'password' => 'new-password-123',
            'password_confirmation' => 'new-password-123',
        ]);

        $response->assertRedirect(route('admin.users.index'));
        $response->assertSessionHas('success');

        $member->refresh();
        $this->assertTrue(Hash::check('new-password-123', $member->password));
        $this->assertFalse(Hash::check('old-password-123', $member->password));

        Notification::assertSentTo($member, AdminResetPasswordNotification::class);
    }

    public function test_non_admin_cannot_reset_user_password(): void
    {
        $member = User::factory()->create(['role' => 'member']);
        $targetUser = User::factory()->create(['role' => 'member']);

        $this->actingAs($member)
            ->post(route('admin.users.reset-password', $targetUser), [
                'password' => 'blocked-password-123',
                'password_confirmation' => 'blocked-password-123',
            ])
            ->assertForbidden();
    }

    public function test_admin_can_deactivate_and_activate_user(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $targetUser = User::factory()->create([
            'role' => 'member',
            'is_active' => true,
        ]);

        $this->actingAs($admin)->post(route('admin.users.update-status', $targetUser), [
            'is_active' => 0,
        ])->assertRedirect(route('admin.users.index'));

        $targetUser->refresh();
        $this->assertFalse($targetUser->is_active);

        $this->actingAs($admin)->post(route('admin.users.update-status', $targetUser), [
            'is_active' => 1,
        ])->assertRedirect(route('admin.users.index'));

        $targetUser->refresh();
        $this->assertTrue($targetUser->is_active);
    }

    public function test_inactive_user_cannot_login(): void
    {
        $inactiveUser = User::factory()->create([
            'email' => 'inactive@example.com',
            'password' => Hash::make('secret-12345'),
            'is_active' => false,
        ]);

        $response = $this->post(route('login'), [
            'email' => $inactiveUser->email,
            'password' => 'secret-12345',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }
}
