<?php

namespace Database\Seeders;

use App\Models\MenuItem;
use Illuminate\Database\Seeder;

class MenuItemSeeder extends Seeder
{
    /**
     * Recreates the original fixed navigation as editable rows, so behavior
     * is unchanged out of the box but is now admin-manageable.
     */
    public function run(): void
    {
        if (MenuItem::query()->exists()) {
            return;
        }

        $about = MenuItem::create([
            'label_ka' => 'ჟურნალის შესახებ',
            'label_en' => 'About the Journal',
            'route_name' => 'home',
            'sort_order' => 10,
        ]);

        MenuItem::create([
            'parent_id' => $about->id,
            'label_ka' => 'მიზნები და ამოცანები',
            'label_en' => 'Aims & Scope',
            'route_name' => 'about.show',
            'route_param' => 'aims-scope',
            'sort_order' => 10,
        ]);

        MenuItem::create([
            'parent_id' => $about->id,
            'label_ka' => 'რეცენზირება და ეთიკა',
            'label_en' => 'Review & Ethics',
            'route_name' => 'about.show',
            'route_param' => 'review-ethics',
            'sort_order' => 20,
        ]);

        MenuItem::create([
            'label_ka' => 'სარედაქციო კოლეგია',
            'label_en' => 'Editorial Board',
            'route_name' => 'editorial-board',
            'sort_order' => 20,
        ]);

        MenuItem::create([
            'label_ka' => 'მიმდინარე ნომერი',
            'label_en' => 'Current Issue',
            'route_name' => 'issues.current',
            'sort_order' => 30,
        ]);

        MenuItem::create([
            'label_ka' => 'არქივი',
            'label_en' => 'Archive',
            'route_name' => 'issues.archive',
            'sort_order' => 40,
        ]);

        MenuItem::create([
            'label_ka' => 'ავტორთა საყურადღებოდ',
            'label_en' => 'For Authors',
            'route_name' => 'for-authors',
            'sort_order' => 50,
        ]);

        MenuItem::create([
            'label_ka' => 'კონტაქტი',
            'label_en' => 'Contact',
            'route_name' => 'contact',
            'sort_order' => 60,
        ]);
    }
}
