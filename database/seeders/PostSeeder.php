<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use App\Models\Category;
use App\Models\Comment;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        $admin      = User::where('role', 'admin')->first();
        $superadmin = User::where('role', 'superadmin')->first();
        $user       = User::where('role', 'user')->first();

        $techCat    = Category::where('slug', 'teknologi')->first();
        $tutorCat   = Category::where('slug', 'tutorial')->first();
        $bisnisCat  = Category::where('slug', 'bisnis')->first();
        $desainCat  = Category::where('slug', 'desain')->first();

        $posts = [
            [
                'user_id'      => $superadmin->id,
                'category_id'  => $techCat->id,
                'title'        => 'Mengenal Laravel 13: Fitur Baru dan Peningkatan',
                'slug'         => 'mengenal-laravel-13-fitur-baru',
                'excerpt'      => 'Laravel 13 hadir dengan banyak fitur baru yang memudahkan pengembangan aplikasi web modern. Mari kita eksplorasi bersama.',
                'content'      => '<p>Laravel 13 adalah versi terbaru dari framework PHP yang paling populer di dunia. Dengan berbagai peningkatan performa dan fitur baru, Laravel 13 semakin memudahkan para developer dalam membangun aplikasi web yang kompleks.</p><h2>Fitur Utama Laravel 13</h2><p>Beberapa fitur utama yang hadir di Laravel 13 antara lain:</p><ul><li><strong>Improved Blade Components</strong> - Komponen Blade kini lebih powerful dan mudah digunakan</li><li><strong>Better Type System</strong> - Dukungan tipe data yang lebih baik</li><li><strong>Enhanced Testing</strong> - Tools testing yang lebih canggih</li><li><strong>Performance Boost</strong> - Peningkatan performa secara keseluruhan</li></ul><p>Laravel terus berkembang dan menjadi pilihan utama para developer PHP di seluruh dunia. Dengan ekosistem yang kaya dan komunitas yang aktif, Laravel 13 semakin memperkuat posisinya sebagai framework PHP terbaik.</p>',
                'status'       => 'published',
                'featured'     => true,
                'views'        => 1250,
                'published_at' => now()->subDays(5),
                'tags'         => [1, 2], // Laravel, PHP
            ],
            [
                'user_id'      => $admin->id,
                'category_id'  => $tutorCat->id,
                'title'        => 'Tutorial: Membuat REST API dengan Laravel 13',
                'slug'         => 'tutorial-rest-api-laravel-13',
                'excerpt'      => 'Panduan lengkap membuat REST API yang clean dan scalable menggunakan Laravel 13 dan best practices modern.',
                'content'      => '<p>Dalam tutorial ini, kita akan belajar membuat REST API yang lengkap menggunakan Laravel 13. REST API adalah fondasi dari aplikasi modern yang memungkinkan komunikasi antara berbagai platform.</p><h2>Persiapan</h2><p>Sebelum memulai, pastikan kamu sudah menginstall:</p><ul><li>PHP 8.2 atau lebih baru</li><li>Composer</li><li>Laravel 13</li></ul><h2>Membuat Controller</h2><p>Pertama, kita buat API controller dengan perintah artisan...</p><pre><code>php artisan make:controller Api/PostController --api</code></pre><p>Controller ini akan secara otomatis memiliki method index, store, show, update, dan destroy yang sesuai dengan standar RESTful.</p>',
                'status'       => 'published',
                'featured'     => false,
                'views'        => 890,
                'published_at' => now()->subDays(3),
                'tags'         => [1, 2, 14], // Laravel, PHP, API
            ],
            [
                'user_id'      => $superadmin->id,
                'category_id'  => $bisnisCat->id,
                'title'        => '10 Tips Membangun Startup Teknologi yang Sukses',
                'slug'         => '10-tips-membangun-startup-teknologi',
                'excerpt'      => 'Membangun startup teknologi bukan hal yang mudah. Berikut 10 tips dari para founder sukses yang bisa kamu terapkan.',
                'content'      => '<p>Dunia startup teknologi penuh dengan tantangan dan peluang. Setiap tahun, ribuan startup lahir, namun hanya sebagian kecil yang berhasil bertahan dan berkembang pesat.</p><h2>1. Validasi Ide Terlebih Dahulu</h2><p>Sebelum membangun produk, validasi ide kamu dengan calon pengguna. Lakukan riset pasar dan pastikan ada kebutuhan nyata yang akan dipenuhi oleh produk kamu.</p><h2>2. Bangun Tim yang Solid</h2><p>Tim adalah aset terbesar startup. Carilah co-founder yang saling melengkapi skill dan memiliki visi yang sama.</p><h2>3. MVP dulu, Sempurna Belakangan</h2><p>Jangan mencoba membangun produk yang sempurna dari awal. Buat Minimum Viable Product (MVP) terlebih dahulu untuk mendapatkan feedback dari pengguna nyata.</p>',
                'status'       => 'published',
                'featured'     => true,
                'views'        => 2100,
                'published_at' => now()->subDays(7),
                'tags'         => [9, 10], // Startup, Produktivitas
            ],
            [
                'user_id'      => $admin->id,
                'category_id'  => $desainCat->id,
                'title'        => 'Prinsip Desain UI/UX yang Wajib Dikuasai Developer',
                'slug'         => 'prinsip-desain-ui-ux-developer',
                'excerpt'      => 'Sebagai developer, memahami prinsip desain UI/UX akan membuat aplikasi yang kamu bangun jauh lebih baik dan user-friendly.',
                'content'      => '<p>Desain yang baik bukan hanya tentang estetika, tetapi juga tentang bagaimana pengguna berinteraksi dengan aplikasi. Sebagai developer, memahami dasar-dasar desain UI/UX akan sangat membantu dalam membangun produk yang berkualitas.</p><h2>1. Hierarchy Visual</h2><p>Pengguna membaca konten secara alami dari atas ke bawah dan dari kiri ke kanan. Gunakan ukuran, warna, dan spacing untuk menciptakan hierarki visual yang jelas.</p><h2>2. Konsistensi</h2><p>Gunakan elemen desain yang konsisten di seluruh aplikasi. Tombol, warna, dan typography harus mengikuti pola yang sama.</p><h2>3. Feedback Visual</h2><p>Setiap aksi pengguna harus mendapat respons visual yang jelas. Loading state, success message, dan error handling yang baik akan meningkatkan user experience.</p>',
                'status'       => 'published',
                'featured'     => false,
                'views'        => 678,
                'published_at' => now()->subDays(2),
                'tags'         => [8, 6, 7], // Desain UI, CSS, HTML
            ],
            [
                'user_id'      => $admin->id,
                'category_id'  => $techCat->id,
                'title'        => 'Pengenalan Artificial Intelligence untuk Pemula',
                'slug'         => 'pengenalan-artificial-intelligence-pemula',
                'excerpt'      => 'AI bukan lagi teknologi masa depan — ini adalah teknologi masa kini. Pelajari konsep dasar AI yang perlu kamu ketahui.',
                'content'      => '<p>Artificial Intelligence (AI) atau Kecerdasan Buatan adalah salah satu teknologi paling transformatif di abad ke-21. Dari asisten virtual hingga kendaraan otonom, AI sudah hadir di mana-mana.</p><h2>Apa itu AI?</h2><p>AI adalah kemampuan mesin untuk meniru kecerdasan manusia dalam melakukan tugas seperti belajar, memecahkan masalah, dan pengambilan keputusan.</p><h2>Cabang-cabang AI</h2><ul><li><strong>Machine Learning</strong> - Mesin yang belajar dari data</li><li><strong>Deep Learning</strong> - Neural network berlapis-lapis</li><li><strong>Natural Language Processing</strong> - Pemrosesan bahasa alami</li><li><strong>Computer Vision</strong> - Pengenalan gambar dan video</li></ul>',
                'status'       => 'published',
                'featured'     => false,
                'views'        => 1567,
                'published_at' => now()->subDays(10),
                'tags'         => [11, 12], // AI, Machine Learning
            ],
            [
                'user_id'      => $superadmin->id,
                'category_id'  => $tutorCat->id,
                'title'        => 'Draft Post: Panduan Database Optimization',
                'slug'         => 'panduan-database-optimization',
                'excerpt'      => 'Panduan lengkap optimasi database untuk performa aplikasi yang lebih baik.',
                'content'      => '<p>Konten masih dalam pengerjaan...</p>',
                'status'       => 'draft',
                'featured'     => false,
                'views'        => 0,
                'published_at' => null,
                'tags'         => [13], // Database
            ],
        ];

        $tags = Tag::all()->keyBy('id');

        foreach ($posts as $postData) {
            $postTags = $postData['tags'] ?? [];
            unset($postData['tags']);

            $post = Post::create($postData);

            if (!empty($postTags)) {
                $post->tags()->attach($postTags);
            }
        }

        // Add sample comments
        $publishedPosts = Post::where('status', 'published')->get();
        foreach ($publishedPosts->take(3) as $post) {
            Comment::create([
                'post_id'     => $post->id,
                'user_id'     => $user->id,
                'content'     => 'Artikel yang sangat informatif! Terima kasih sudah berbagi. Sangat membantu untuk pemahaman saya.',
                'is_approved' => true,
            ]);
            Comment::create([
                'post_id'     => $post->id,
                'user_id'     => $admin->id,
                'content'     => 'Konten yang bagus! Saya akan coba terapkan tips-tips ini dalam proyek saya berikutnya.',
                'is_approved' => true,
            ]);
            Comment::create([
                'post_id'     => $post->id,
                'user_id'     => $user->id,
                'content'     => 'Ada yang bisa dijelaskan lebih detail tentang bagian kedua? Sedikit membingungkan bagi saya yang masih pemula.',
                'is_approved' => false,
            ]);
        }
    }
}
