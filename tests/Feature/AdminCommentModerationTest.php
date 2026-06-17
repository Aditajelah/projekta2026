<?php

namespace Tests\Feature;

use App\Models\Destination;
use App\Models\Rating;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminCommentModerationTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_delete_comment(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $member = User::factory()->create(['role' => 'member']);

        $destination = Destination::create([
            'name' => 'Pantai Test',
            'location' => 'Test City',
            'price' => 0,
            'category' => 'alam',
            'status_lokasi' => 'terkenal',
        ]);

        $comment = Rating::create([
            'user_id' => $member->id,
            'rateable_type' => Destination::class,
            'rateable_id' => $destination->getKey(),
            'rating' => 4,
            'review' => 'Komentar untuk dihapus',
        ]);

        $response = $this->actingAs($admin)
            ->delete(route('admin.comments.destroy', $comment));

        $response->assertRedirect(route('admin.comments.index'));
        $this->assertDatabaseMissing('ratings', [
            'id' => $comment->id,
        ]);
        $this->assertDatabaseHas('audit_logs', [
            'action' => 'delete',
            'entity_type' => 'comments',
            'entity_id' => $comment->id,
        ]);
    }

    public function test_admin_can_send_warning_up_to_three_times_only(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $member = User::factory()->create([
            'role' => 'member',
            'warning_count' => 0,
        ]);

        $destination = Destination::create([
            'name' => 'Danau Test',
            'location' => 'Test City',
            'price' => 0,
            'category' => 'alam',
            'status_lokasi' => 'terkenal',
        ]);

        $comment = Rating::create([
            'user_id' => $member->id,
            'rateable_type' => Destination::class,
            'rateable_id' => $destination->getKey(),
            'rating' => 3,
            'review' => 'Komentar untuk peringatan',
        ]);

        $this->actingAs($admin)->post(route('admin.comments.warning', $comment));
        $this->actingAs($admin)->post(route('admin.comments.warning', $comment));
        $this->actingAs($admin)->post(route('admin.comments.warning', $comment));

        $member->refresh();
        $this->assertSame(3, $member->warning_count);

        $response = $this->actingAs($admin)
            ->post(route('admin.comments.warning', $comment));

        $response->assertRedirect(route('admin.comments.index'));
        $response->assertSessionHasErrors('warning');

        $member->refresh();
        $this->assertSame(3, $member->warning_count);
    }
}
