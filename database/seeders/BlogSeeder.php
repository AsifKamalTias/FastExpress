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
        for($i=0; $i<25; $i++)
        {
            Blog::create([
                'blog_title' => 'Our Blog Title '.$i,
                'blog_content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam euismod, nisi eu consectetur consectetur, nisi nisi consectetur nisi, euismod nisi nisi euismod nisi. Nam euismod, nisi eu consectetur consectetur, nisi nisi consectetur nisi, euismod nisi nisi euismod nisi. Nam euismod, nisi eu consectetur consectetur, nisi nisi consectetur nisi, euismod nisi nisi euismod nisi. Nam euismod, nisi eu consectetur consectetur, nisi nisi consectetur nisi, euismod nisi nisi euismod nisi. Nam euismod, nisi eu consectetur consectetur, nisi nisi consectetur nisi, euismod nisi nisi euismod nisi. Nam euismod, nisi eu consectetur consectetur, nisi nisi consectetur nisi, euismod nisi nisi euismod nisi. Nam euismod, nisi eu consectetur consectetur, nisi nisi consectetur nisi, euismod nisi nisi euismod nisi. Nam euismod, nisi eu consectetur consectetur, nisi nisi consectetur nisi, euismod nisi nisi euismod nisi. Nam euismod, nisi eu consectetur consectetur, nisi nisi consectetur nisi, euismod nisi nisi euismod nisi. Nam euismod, nisi eu consectetur consectetur, nisi nisi consectetur nisi, euismod nisi nisi euismod nisi. Nam euismod, nisi eu consectetur consectetur, nisi nisi consect'
            ]);
        }
    }
}
