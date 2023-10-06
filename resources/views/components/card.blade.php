    <h3>{{$title}}</h3>
    @foreach ($items as $item)
        
    <div class="col-4">
        <div class="card">
             <img src="https://process.fs.teachablecdn.com/ADNupMnWyR7kCWRvm76Laz/resize=width:705/https://cdn.filestackcontent.com/TZLXpJ9ORhmBgJUs1v5A" class="card-img-top" alt="...">
            <div class="card-body">
                <a href="{{route('posts.show' , ['post' => $item->id])}}">{{$item->title}}</a>
                <p class="card-text">{{ \Illuminate\Support\Str::limit($item->content, 20) }}</p>
                <span class="badge text-bg-info">{{$item->comments_count}} Comment</span>
            </div>
        </div>
    </div>
    @endforeach
