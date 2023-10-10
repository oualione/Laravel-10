<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Comment;
use App\Models\Scopes\DeletedPostAbiltyByAdmin;
use App\Models\Scopes\ShowLatest;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    protected $fillable = [
        'title',
        'content',
        'slug',
        'active',
        'user_id',
        'tag_id'
    ];
    use HasFactory;
    use SoftDeletes;

    

    public function user()
    {
        return $this->belongsTo(User::class);
    }

   //  we change this relation from one to many to Morph one to many
    // public function comments()
    // {
    //     return $this->hasMany(Comment::class);
    // }

    public function comments() : MorphMany {
        return $this->morphMany(Comment::class, 'commentable');
    }
    

    public function scopeMostCommentedPost($query){
        return $query->withCount('comments')->orderBy('comments_count','desc');
    }

    public static function boot()
    {

        static::addGlobalScope(new DeletedPostAbiltyByAdmin);
        parent::boot();

        static::addGlobalScope(new ShowLatest);

        static::deleting(function (Post $post) {
            $post->comments()->delete();
        });

        static::restoring(function ($post) {
            $post->comments()->restore();
        });
    }

    public function restoreWithComments()
    {
        $this->restore();
        $this->comments()->restore();
    }

    public function tags(){
        return $this->belongsToMany(Tag::class);
    }

    public function image(): MorphOne
    {
        return $this->morphOne(Image::class, 'imageable');
    }



    
    
}
