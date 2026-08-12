<?php

namespace Tests\Feature;

use App\Models\MenuItem;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MenuItemTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(\Database\Seeders\PageSeeder::class);
        $this->seed(\Database\Seeders\SettingSeeder::class);
        $this->seed(\Database\Seeders\MenuItemSeeder::class);
    }

    public function test_homepage_renders_seeded_menu_with_submenu(): void
    {
        $response = $this->get('/');

        $response->assertOk()
            ->assertSee('სარედაქციო კოლეგია', false)
            ->assertSee('მიზნები და ამოცანები', false);
    }

    public function test_admin_can_create_top_level_menu_item_with_custom_url(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->post('/admin/menu-items', [
            'label_ka' => 'ბმული',
            'label_en' => 'External Link',
            'link_type' => 'custom',
            'custom_url' => 'https://example.com',
        ])->assertRedirect(route('admin.menu-items.index'));

        $item = MenuItem::where('label_en', 'External Link')->firstOrFail();
        $this->assertNull($item->parent_id);
        $this->assertSame('https://example.com', $item->custom_url);
        $this->assertSame('https://example.com', $item->resolved_url);
    }

    public function test_admin_can_create_submenu_item_under_existing_parent_with_children(): void
    {
        $user = User::factory()->create();
        $about = MenuItem::where('route_name', 'home')->firstOrFail();
        $this->assertTrue($about->children()->exists());

        $this->actingAs($user)->post('/admin/menu-items', [
            'label_ka' => 'ინდექსირება',
            'label_en' => 'Indexing',
            'link_type' => 'internal',
            'internal_target' => 'contact',
            'parent_id' => $about->id,
        ])->assertRedirect(route('admin.menu-items.index'));

        $this->assertSame(3, $about->children()->count());
    }

    public function test_item_with_children_cannot_be_assigned_a_parent(): void
    {
        $user = User::factory()->create();
        $about = MenuItem::where('route_name', 'home')->firstOrFail();
        $editorialBoard = MenuItem::where('route_name', 'editorial-board')->firstOrFail();

        $this->actingAs($user)->put(route('admin.menu-items.update', $about), [
            'label_ka' => $about->label_ka,
            'label_en' => $about->label_en,
            'link_type' => 'internal',
            'internal_target' => 'home',
            'parent_id' => $editorialBoard->id,
        ])->assertStatus(422);
    }

    public function test_admin_can_delete_a_menu_item(): void
    {
        $user = User::factory()->create();
        $editorialBoard = MenuItem::where('route_name', 'editorial-board')->firstOrFail();

        $this->actingAs($user)
            ->delete(route('admin.menu-items.destroy', $editorialBoard))
            ->assertRedirect(route('admin.menu-items.index'));

        $this->assertDatabaseMissing('menu_items', ['id' => $editorialBoard->id]);
    }
}
