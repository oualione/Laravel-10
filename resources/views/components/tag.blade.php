@foreach ($tags as $tag)
    <span class="badge text-bg-success"><a href={{route ('posts-tag-index', [$tag->id])}}>{{$tag->name}}</a></span>
@endforeach