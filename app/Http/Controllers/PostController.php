<?php

namespace App\Http\Controllers;

use Alert;
use App\Http\Requests\StorePost;
use App\Models\Image;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        return $this->middleware('auth')->only(['create', 'edit', 'delete', 'update']);
    }

    
    public function index()
    {

        $posts = Post::withCount('comments')->with('user')->with('tags')->get();
        //Example of Caching data using facade Cache

        // $mostCommentedPost = Cache::remember('most_commented', now()->addSeconds(10), function (){
        //     return Post::mostCommentedPost()->take(3)->get();
        // });


        // // $mostCommentedPost = Post::mostCommentedPost()->take(3)->get();
        // $mostActiveUser = User::mostActivatedUser()->take(3)->get();
        // $mostActiveUserLastMonth = User::mostActivatedUserLastMonth()->take(3)->get();
        return view('posts.index', [
            'tab' => 'index',
            'data' => $posts,
        // 'mostCommentedPost' => $mostCommentedPost,
        // 'mostActiveUser' => $mostActiveUser,
        // 'mostActiveUserLastMonth' => $mostActiveUserLastMonth,
        
            ]);
    }

    public function archive()
    {
        $posts = Post::onlyTrashed()->withCount('comments')->get();
        return view('posts.index', ['data' => $posts,
                                    'tab' => 'archive']);
    }

    public function all()
    {
        $posts = Post::withTrashed()->withCount('comments')->get();
        return view('posts.index', ['data' => $posts, 'tab' => 'all']);
    }

    public function restore($id){
        $post = Post::withTrashed()->find($id);
        $post->restoreWithComments();
        return redirect('posts')->with('status', 'Post Restored Successfully !');

    }

    public function drop($id)
    {
        $post = Post::withTrashed()->find($id);
        $post->forceDelete();
        return redirect('posts')->with('status', 'Post Restored Successfully !');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePost $request)
    {
        //     $request->validate([
        //         'title' => 'required|min:3|max:100',
        //         'content' => 'required|min=10|max=255'
        // ]);

        // $hasFile = $request->hasFile('image');
        // dump($hasFile);
        


        $data = $request->only(['title', 'content']);
        $data['slug'] = Str::slug($data['title'], '-');
        $data['active'] = false;
        $data['user_id'] = $request->user()->id;
        

        $post = Post::create($data);

        if ($request->hasFile('image')) {
           $path = $request->file('image')->store('posts');

           $image = new Image(['path' => $path]);
           $post->image()->save($image);
            
        //    $image->path = $path;
        //    $image->post_id = $post->id;
        //    $image->save();

        //    $post->image()->save($image);
        }




        // $post->title = $request->input('title');
        // $post->content = $request->input('description');
        // $post->slug = Str::slug($post->title, '-');
        // $post->active = false;
        // $post->save();

       
        return redirect('posts')->with('status', 'Post Created Successfully !');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $showPost = Cache::remember("show-post-{$id}", 60, function() use ($id) {
            return Post::findOrFail($id);
        });

        
        $latestComments = $showPost->comments()->latestComments()->get();

        return view('posts.show', ['post' => $showPost, 'comments' => $latestComments]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::findOrFail($id);
        $this->authorize("edit", $post);
        return view('posts.edit', ['post' => $post]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StorePost $request, $id)
    {


        $post = Post::findOrFail($id);

        // if (Gate::denies('post.update', $post)) {
        //     return abort(403,'Access Denied, You dont have permission to update');
        // }
        $this->authorize("update", $post);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('posts');

            if($post->image){
                Storage::delete($post->image->path);
                $post->image->path = $path;
                $post->image->save();
            }else{
                $post->image()->save(Image::make(['path'=> $path]));
            }    

        }

        $post->title = $request->input('title');
        $post->content = $request->input('content');
        $post->slug = Str::slug($request->input('title'),'-');
        $post->save();
        return redirect('posts')->with('status', 'Post Updated Successfully !');


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    
    {
        $post = Post::findOrFail($id);
        $this->authorize("delete", $post);
        $post->destroy($id);
        
        return redirect('posts')->with('status', 'Post Deleted Successfully !');
        
    }
}
