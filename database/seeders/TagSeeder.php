<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    public function run(): void
    {
        $tags = [
            'Laravel', 'PHP', 'JavaScript', 'Vue.js', 'React',
            'CSS', 'HTML', 'Desain UI', 'Startup', 'Produktivitas',
            'AI', 'Machine Learning', 'Database', 'API', 'Open Source',
        ];

        foreach ($tags as $tag) {
            Tag::create(['name' => $tag]);
        }
    }
}
