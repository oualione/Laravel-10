@extends('layout')

@section('content')
    <h3>{{$post->title}}</h3>
    <p>{{$post->content}}</p>
    <span>{{$post->updated_at->diffForHumans()}}</span>
    <hr>
     <x-tag :tags="$post->tags"></x-tag>
    <hr>
   @if ($post->comments->count() > 0)
    <h3>Comments:</h3>
    <ul>
        @foreach ($comments as $comment)
            <li>{{ $comment->content }}</li>
            {{-- <p>{{$comment->updated_at->diffForHumans()}}</p> --}}
            <x-updated :date="$post->updated_at" :name="$comment->user->name" :userId="$post->user->id"></x-updated>
        @endforeach
    </ul>

    @include('comment.form', ['id' => $post->id])
@else
    <p>No comments yet.</p>
@endif

    @if ($post->active)
        <span>This Post is Active</span>
    @else
    <span>Post not Active</span>
    @endif

@endsection