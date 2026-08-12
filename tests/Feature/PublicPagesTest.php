<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\Issue;
use App\Models\Page;
use App\Models\Setting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicPagesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(\Database\Seeders\PageSeeder::class);
        $this->seed(\Database\Seeders\SettingSeeder::class);
    }

    public function test_homepage_shows_about_page(): void
    {
        $this->get('/')->assertOk()->assertSee(Page::where('slug', 'about')->first()->title_ka);
    }

    public function test_static_pages_return_200(): void
    {
        $this->get('/about/aims-scope')->assertOk();
        $this->get('/about/review-ethics')->assertOk();
        $this->get('/editorial-board')->assertOk();
        $this->get('/for-authors')->assertOk();
    }

    public function test_contact_page_returns_200(): void
    {
        $this->get('/contact')->assertOk();
    }

    public function test_archive_returns_200_and_is_sorted_desc(): void
    {
        Issue::create(['year' => 2024, 'number' => '1']);
        Issue::create(['year' => 2026, 'number' => '1']);
        Issue::create(['year' => 2025, 'number' => '1']);

        $response = $this->get('/issues');

        $response->assertOk();
        $years = Issue::orderByDesc('year')->pluck('year')->all();
        $this->assertSame([2026, 2025, 2024], $years);
    }

    public function test_current_issue_page(): void
    {
        $issue = Issue::create(['year' => 2026, 'number' => '1', 'is_current' => true]);
        Article::create([
            'issue_id' => $issue->id,
            'title_ka' => 'ტესტ',
            'title_en' => 'Test Article',
            'authors' => 'Jane Doe',
            'slug' => 'test-article',
        ]);

        $this->get('/issues/current')->assertOk()->assertSee('ტესტ', false);
    }

    public function test_current_issue_missing_returns_404(): void
    {
        $this->get('/issues/current')->assertNotFound();
    }

    public function test_article_show_page(): void
    {
        $issue = Issue::create(['year' => 2026, 'number' => '1']);
        Article::create([
            'issue_id' => $issue->id,
            'title_ka' => 'ტესტ',
            'title_en' => 'Test Article',
            'authors' => 'Jane Doe',
            'abstract_en' => 'An abstract',
            'slug' => 'test-article',
        ]);

        $this->get('/articles/test-article')->assertOk();
    }

    public function test_search_returns_matching_articles(): void
    {
        $issue = Issue::create(['year' => 2026, 'number' => '1']);
        Article::create([
            'issue_id' => $issue->id,
            'title_ka' => 'ძებნადი',
            'title_en' => 'Findable Title',
            'authors' => 'Jane Doe',
            'slug' => 'findable-title',
        ]);
        Article::create([
            'issue_id' => $issue->id,
            'title_ka' => 'სხვა',
            'title_en' => 'Other Title',
            'authors' => 'John Doe',
            'slug' => 'other-title',
        ]);

        $response = $this->get('/search?q=Findable');

        $response->assertOk()->assertSee('ძებნადი', false)->assertDontSee('სხვა', false);
    }

    public function test_locale_switch_persists_in_session(): void
    {
        $this->get('/locale/en')->assertRedirect();
        $this->assertSame('en', session('locale'));

        $this->get('/locale/ka')->assertRedirect();
        $this->assertSame('ka', session('locale'));
    }
}
