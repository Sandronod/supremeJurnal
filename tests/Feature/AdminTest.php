<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\Issue;
use App\Models\Page;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(\Database\Seeders\PageSeeder::class);
        $this->seed(\Database\Seeders\SettingSeeder::class);
        Storage::fake('public');
    }

    public function test_guest_is_redirected_to_login(): void
    {
        $this->get('/admin')->assertRedirect(route('admin.login'));
    }

    public function test_admin_can_log_in_and_see_dashboard(): void
    {
        $user = User::factory()->create();

        $this->post('/admin/login', [
            'email' => $user->email,
            'password' => 'password',
        ])->assertRedirect('/admin');

        $this->get('/admin')->assertOk();
    }

    public function test_admin_can_update_a_page(): void
    {
        $user = User::factory()->create();
        $page = Page::where('slug', 'about')->firstOrFail();

        $this->actingAs($user)->put(route('admin.pages.update', $page), [
            'title_ka' => 'ახალი სათაური',
            'title_en' => 'New Title',
            'body_ka' => '<p>ტექსტი</p>',
            'body_en' => '<p>Text</p>',
        ])->assertRedirect(route('admin.pages.index'));

        $this->assertSame('New Title', $page->fresh()->title_en);
    }

    public function test_admin_can_create_issue_with_pdf_and_set_it_current(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->post('/admin/issues', [
            'year' => 2026,
            'number' => '1',
            'is_current' => '1',
            'pdf' => UploadedFile::fake()->create('issue.pdf', 100, 'application/pdf'),
        ])->assertRedirect(route('admin.issues.index'));

        $issue = Issue::firstOrFail();
        $this->assertTrue($issue->is_current);
        $this->assertNotNull($issue->pdf_path);
        Storage::disk('public')->assertExists($issue->pdf_path);

        $secondIssue = Issue::create(['year' => 2025, 'number' => '1']);
        $this->actingAs($user)
            ->post(route('admin.issues.set-current', $secondIssue))
            ->assertRedirect(route('admin.issues.index'));

        $this->assertFalse($issue->fresh()->is_current);
        $this->assertTrue($secondIssue->fresh()->is_current);
    }

    public function test_admin_can_create_and_delete_an_article(): void
    {
        $user = User::factory()->create();
        $issue = Issue::create(['year' => 2026, 'number' => '1']);

        $this->actingAs($user)->post('/admin/articles', [
            'issue_id' => $issue->id,
            'title_ka' => 'სათაური',
            'title_en' => 'A Title',
            'authors' => 'Jane Doe',
            'cover_image' => UploadedFile::fake()->image('cover.jpg'),
        ])->assertRedirect(route('admin.articles.index'));

        $article = Article::firstOrFail();
        $this->assertSame('a-title', $article->slug);
        $this->assertNotNull($article->cover_image_path);
        Storage::disk('public')->assertExists($article->cover_image_path);

        $this->actingAs($user)
            ->delete(route('admin.articles.destroy', $article))
            ->assertRedirect(route('admin.articles.index'));

        $this->assertDatabaseMissing('articles', ['id' => $article->id]);
    }
}
