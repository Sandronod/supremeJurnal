<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\Issue;
use App\Models\MenuItem;
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

    public function test_admin_can_create_issue_and_set_it_current(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->post('/admin/issues', [
            'year' => 2026,
            'number' => '1',
            'is_current' => '1',
        ])->assertRedirect();

        $issue = Issue::firstOrFail();
        $this->assertTrue($issue->is_current);

        $secondIssue = Issue::create(['year' => 2025, 'number' => '1']);
        $this->actingAs($user)
            ->post(route('admin.issues.set-current', $secondIssue))
            ->assertRedirect(route('admin.issues.index'));

        $this->assertFalse($issue->fresh()->is_current);
        $this->assertTrue($secondIssue->fresh()->is_current);
    }

    public function test_admin_can_set_a_custom_issue_title(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->post('/admin/issues', [
            'year' => 2026,
            'number' => '1',
            'title_ka' => 'ჩემი ნომრის სახელი',
            'title_en' => 'My Issue Title',
        ])->assertRedirect();

        $issue = Issue::firstOrFail();
        $this->assertSame('ჩემი ნომრის სახელი', $issue->title_ka);
        $this->assertSame('My Issue Title', $issue->title_en);

        app()->setLocale('ka');
        $this->assertSame('ჩემი ნომრის სახელი', $issue->fresh()->title);

        app()->setLocale('en');
        $this->assertSame('My Issue Title', $issue->fresh()->title);
    }

    public function test_admin_can_add_and_delete_an_issue_file(): void
    {
        $user = User::factory()->create();
        $issue = Issue::create(['year' => 2026, 'number' => '1']);

        $this->actingAs($user)->post(route('admin.issues.files.store', $issue), [
            'label_ka' => 'ნომერი 1',
            'label_en' => 'Issue 1',
            'file' => UploadedFile::fake()->create('issue.pdf', 100, 'application/pdf'),
        ])->assertRedirect(route('admin.issues.files.index', $issue));

        $file = $issue->files()->firstOrFail();
        $this->assertSame('Issue 1', $file->label_en);
        Storage::disk('public')->assertExists($file->file_path);

        $this->actingAs($user)
            ->delete(route('admin.issues.files.destroy', [$issue, $file]))
            ->assertRedirect(route('admin.issues.files.index', $issue));

        $this->assertDatabaseMissing('issue_files', ['id' => $file->id]);
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

    public function test_admin_can_create_a_custom_page_and_it_is_publicly_viewable(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->post('/admin/pages', [
            'title_ka' => 'ინდექსირება',
            'title_en' => 'Indexing',
            'body_ka' => '<p>ტექსტი</p>',
            'body_en' => '<p>Text</p>',
        ])->assertRedirect(route('admin.pages.index'));

        $page = Page::where('title_en', 'Indexing')->firstOrFail();
        $this->assertSame('indexing', $page->slug);
        $this->assertFalse($page->isFixed());

        $this->get('/ka/page/indexing')->assertOk()->assertSee('ინდექსირება', false);
        $this->assertArrayHasKey('page.indexing', MenuItem::internalTargets());
    }

    public function test_fixed_page_cannot_be_deleted_but_custom_page_can(): void
    {
        $user = User::factory()->create();
        $fixed = Page::where('slug', 'about')->firstOrFail();
        $custom = Page::create([
            'slug' => 'custom-page',
            'title_ka' => 'ტესტი',
            'title_en' => 'Test',
        ]);

        $this->actingAs($user)
            ->delete(route('admin.pages.destroy', $fixed))
            ->assertStatus(422);
        $this->assertDatabaseHas('pages', ['id' => $fixed->id]);

        $this->actingAs($user)
            ->delete(route('admin.pages.destroy', $custom))
            ->assertRedirect(route('admin.pages.index'));
        $this->assertDatabaseMissing('pages', ['id' => $custom->id]);
    }
}
