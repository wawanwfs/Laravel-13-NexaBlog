<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Teknologi',   'slug' => 'teknologi',   'color' => '#6366f1', 'description' => 'Artikel seputar teknologi, gadget, dan inovasi terbaru.'],
            ['name' => 'Desain',      'slug' => 'desain',      'color' => '#ec4899', 'description' => 'Tips dan inspirasi desain grafis, UI/UX, dan seni digital.'],
            ['name' => 'Bisnis',      'slug' => 'bisnis',      'color' => '#f59e0b', 'description' => 'Strategi bisnis, entrepreneurship, dan dunia startup.'],
            ['name' => 'Gaya Hidup',  'slug' => 'gaya-hidup',  'color' => '#10b981', 'description' => 'Lifestyle, kesehatan, dan tips kehidupan sehari-hari.'],
            ['name' => 'Tutorial',    'slug' => 'tutorial',    'color' => '#3b82f6', 'description' => 'Panduan langkah demi langkah untuk berbagai topik.'],
            ['name' => 'Berita',      'slug' => 'berita',      'color' => '#ef4444', 'description' => 'Berita terkini dari berbagai penjuru dunia.'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
