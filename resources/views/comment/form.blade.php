@auth
    
<div class="row">
    <div class="col-md-12 my-3">
        <form method="POST" action={{route('posts.comments.store', ['post' => $id])}}>
            @csrf
            <div class="form-group my-3">
              <label for="content">Add a Comment</label>
              <textarea class="form-control" name="content" id="content" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Add</button>
        </form>
    </div>
</div>
<x-error></x-error>
@else
<div class="row">
    <div class="col-md-12">
        <div class="alert alert-primary" role="alert">
            <strong><a href={{route('login')}}>To Comment, You need sign in !</a></strong>
        </div>
    </div>
</div>
@endauth
