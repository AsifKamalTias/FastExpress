<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Blog;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i=0; $i<9; $i++)
        {
            Blog::create([
                'blog_title' => 'My title',
                'blog_content' => 'my description'
            ]);
        }
    }
}
