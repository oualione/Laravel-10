@extends('layout')


@section('content')
   <x-flash></x-flash>

    <div class="row mt-3">
        <h2 class="text-center">ALL POSTS</h2>
    </div>

    {{-- <div class="row my-3">
    <nav class="nav nav-tabs nav-stacked">
        <a class="nav-link @if ($tab == 'index') active @endif" href="{{route('posts.index')}}">LIST OF POSTS</a>
        <a class="nav-link @if ($tab == 'archive') active @endif" href="{{route('posts-archive')}}">ARCHIVE</a>
        <a class="nav-link @if ($tab == 'all') active @endif" href="{{route('all-posts')}}">ALL POSTS</a>
    </nav>
</div> --}}
    <div class="my-3">
        <h3>{{ $data->count() }} Post(s)</h3>
    </div>
    <div class="row">
        {{-- <h3>Most Commented Posts</h3>
    @foreach ($mostCommentedPost as $post)
        
    <div class="col-4">
        <div class="card">
             <img src="https://process.fs.teachablecdn.com/ADNupMnWyR7kCWRvm76Laz/resize=width:705/https://cdn.filestackcontent.com/TZLXpJ9ORhmBgJUs1v5A" class="card-img-top" alt="...">
            <div class="card-body">
                <a href="{{route('posts.show' , ['post' => $post->id])}}">{{$post->title}}</a>
                <p class="card-text">{{ \Illuminate\Support\Str::limit($post->content, 20) }}</p>
                <span class="badge text-bg-info">{{$post->comments_count}} Comment</span>
            </div>
        </div>
    </div>
    @endforeach --}}
        <x-card title="Most Commented Posts" :items="$mostCommentedPost"></x-card>

        <h3>Most Active User</h3>
        @foreach ($mostActiveUser as $user)
            <div class="col-4">
                <div class="card">
                    <img src="https://process.fs.teachablecdn.com/ADNupMnWyR7kCWRvm76Laz/resize=width:705/https://cdn.filestackcontent.com/TZLXpJ9ORhmBgJUs1v5A"
                        class="card-img-top" alt="...">
                    <div class="card-body">
                        <h3>{{ $user->name }}<h3>

                                <span class="badge text-bg-info">{{ $user->post_count }} Post</span>
                    </div>
                </div>
            </div>
        @endforeach

        <h3>Most Active User Last Month</h3>
        @foreach ($mostActiveUserLastMonth as $user)
            <div class="col-4">
                <div class="card">
                    <img src="https://process.fs.teachablecdn.com/ADNupMnWyR7kCWRvm76Laz/resize=width:705/https://cdn.filestackcontent.com/TZLXpJ9ORhmBgJUs1v5A"
                        class="card-img-top" alt="...">
                    <div class="card-body">
                        <h3>{{ $user->name }}<h3>

                                <span class="badge text-bg-info">{{ $user->post_count }} Post</span>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="row mx-auto">
        <h3>All Posts</h3>
        @foreach ($data as $post)
            <div class="col-md-4 mt-3">
                <div class="card" style="width:18rem;">
                    @if ($post->image)
                        <img src="{{ $post->image->url() ?? null }}" class="card-img-top" alt="...">
                    @endif
                    <div class="card-body">

                        @if ($post->created_at->diffInHours() < 1)
                            <x-badge type="light">New</x-badge>
                        @else
                            <x-badge type="dark">Old</x-badge>
                        @endif
                        @if ($post->trashed())
                            <del>
                                <a href="{{ route('posts.show', ['post' => $post->id]) }}"
                                    class="card-title">{{ $post->title }}</a>
                            </del>
                        @else
                            <a href="{{ route('posts.show', ['post' => $post->id]) }}"
                                class="card-title">{{ $post->title }}</a>
                        @endif
                        <x-tag :tags="$post->tags"></x-tag>
                        <p class="card-text">
                            {{ \Illuminate\Support\Str::limit($post->content, 20) }}
                            @if (strlen($post->content) > 15)
                                <a href="{{ route('posts.show', ['post' => $post->id]) }}" class="card-link"
                                    style="text-decoration: none">Read More</a>
                            @endif
                        </p>
                        @component('partials.badge', ['type' => 'info'])
                            {{ $post->comments_count }} Comment
                        @endcomponent
                        <x-updated :date="$post->updated_at" :name="$post->user->name" :userId="$post->user->id" ></x-updated>
                        @auth
                            @can('update', $post)
                                <a href={{ route('posts.edit', ['post' => $post->id]) }} class="btn btn-warning">EDIT</a>
                            @endcan

                            @cannot('delete', $post)
                                @component('partials.badge', ['type' => 'danger'])
                                    You Can not Delete this POST!
                                @endcomponent
                            @endcannot
                            @if (!$post->deleted_at)
                                @can('delete', $post)
                                    <form method="POST" style="display: inline;"
                                        action="{{ route('posts.destroy', ['post' => $post->id]) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">DELETE</button>
                                    </form>
                                @endcan
                            @else
                                @can('restore', $post)
                                    <form method="POST" style="display: inline;"
                                        action="{{ route('posts-restore', ['id' => $post->id]) }}">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-dark">RESTORE</button>
                                    </form>
                                @endcan

                                @can('forceDelete', $post)
                                    <form method="POST" style="display: inline;"
                                        action="{{ route('posts-drop', ['id' => $post->id]) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">DROP</button>
                                    </form>
                                @endcan
                            @endif
                        @endauth


                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
