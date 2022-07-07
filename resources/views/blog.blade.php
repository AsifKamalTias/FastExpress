@extends('layouts.app')
@section('content')
<div class="container m-5">
    <h1 class="text-center">
        {{$blog->blog_title}}
    </h1>
    <div>
        <p>{{$blog->blog_content}}</p>
    </div>
</div>
@endsection