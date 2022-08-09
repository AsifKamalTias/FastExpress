@extends('layouts.app')
@section('content')
<div class="container m-5">
    <h1>Blogs</h1>
    @foreach($blogs as $blog)
    <div class="card m-5">
        <div class="card-body">
            <h5 class="card-title">{{$blog->blog_title}}</h5>
            <a href="{{route('blog',['id'=>$blog->id])}}" class="btn btn-success">Description</a>
        </div>
        <div class="card-footer text-muted">
            {{$blog->updated_at}}
        </div>
    </div>
    @endforeach
</div>
<div class="container d-flex align-items-center justify-content-center">
{!! $blogs->links('pagination::bootstrap-4') !!}
</div>

@endsection