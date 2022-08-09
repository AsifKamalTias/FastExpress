<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

class BlogsController extends Controller
{
    function viewBlogs()
    {
        $blogs = Blog::paginate(5);
        return view('blogs', compact('blogs'));
    }

    function blogsResponse()
    {
        $blogs = Blog::latest()->paginate(6);
        return response()->json($blogs);
    }

    function viewBlog($id)
    {
        $blog = Blog::where('id', '=', $id)->get();
        $blog = $blog[0];
        return view('blog', compact('blog'));
    }

    function blogResponse($id)
    {
        $blog = Blog::where('id', '=', $id)->first();
        return response()->json($blog);
    }
}
