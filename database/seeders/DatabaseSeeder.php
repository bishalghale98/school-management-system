<?php

namespace Database\Seeders;

use App\Models\AdmissionSetting;
use App\Models\DownloadCategory;
use App\Models\Page;
use App\Models\PostCategory;
use App\Models\SiteSetting;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin user
        User::firstOrCreate(
            ['email' => 'admin@school.com'],
            [
                'name' => 'Admin',
                'password' => bcrypt('password'),
                'role' => 'super_admin',
                'email_verified_at' => now(),
            ]
        );

        // Post categories
        $postCategories = ['Notice', 'News', 'Event', 'Routine', 'Result'];
        foreach ($postCategories as $name) {
            PostCategory::firstOrCreate(
                ['slug' => Str::slug($name)],
                ['name' => $name]
            );
        }

        // Download categories
        $downloadCategories = ['Prospectus', 'Calendar', 'Forms', 'Fee', 'App'];
        foreach ($downloadCategories as $name) {
            DownloadCategory::firstOrCreate(
                ['slug' => Str::slug($name)],
                ['name' => $name]
            );
        }

        // Default pages
        $pages = [
            ['title' => 'School Overview', 'slug' => 'school-overview', 'status' => 'published', 'sort_order' => 1],
            ['title' => 'Record of Achievements', 'slug' => 'record-of-achievements', 'status' => 'published', 'sort_order' => 2],
            ['title' => 'Message from the Chairman', 'slug' => 'message-from-the-chairman', 'status' => 'published', 'sort_order' => 3],
            ['title' => 'Message from the Principal', 'slug' => 'message-from-the-principal', 'status' => 'published', 'sort_order' => 4],
            ['title' => 'Publication', 'slug' => 'publication', 'status' => 'published', 'sort_order' => 5],
        ];
        foreach ($pages as $page) {
            Page::firstOrCreate(['slug' => $page['slug']], $page);
        }

        // Site settings
        SiteSetting::firstOrCreate(['id' => 1], [
            'site_name' => 'My School',
            'tagline' => 'Excellence in Education',
        ]);

        // Admission settings
        AdmissionSetting::firstOrCreate(['id' => 1], [
            'is_open' => false,
            'content' => '<p>Admission information will be updated soon.</p>',
            'requirements' => ['Birth Certificate', 'Previous School Records', 'Passport Photos'],
        ]);
    }
}
