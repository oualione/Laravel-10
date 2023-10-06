@extends('layout')

@section('content')

<form method="POST" action="{{ route('posts.update', ['post' => $post->id]) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div>
        
        @include('posts.form')

        
    </div>

</form>
    
@endsection