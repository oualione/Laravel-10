@extends('layout')

@section('content')

<div class="container mt-5">
        <h1 class="mb-4">Create New Post</h1>
        <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div>
                @include('posts.form')

            </div>

        </form>
</div>
    
@endsection