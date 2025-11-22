<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use App\Livewire\Admin\Schedule\Index;
use App\Models\User;

class AdminScheduleIndexFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_class_exists()
    {
        // Ensure the component class can be autoloaded
        self::assertTrue(class_exists(Index::class));
    }
    public function test_guest_is_redirected_to_login_for_admin_schedules()
    {
        $response = $this->get('/admin/schedules');
        $response->assertRedirect('/login');
    }

    public function test_authenticated_user_is_not_redirected_to_login_for_admin_schedules()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('/admin/schedules');
        $this->assertFalse($response->isRedirection(), 'Authenticated user was redirected with status '.$response->getStatusCode());
    }

    public function test_index_livewire_component_can_be_resolved()
    {
        $this->assertTrue(class_exists(Index::class));
    }
}
