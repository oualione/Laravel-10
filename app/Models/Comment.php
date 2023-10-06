<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Post;
use App\Models\Scopes\ShowLatest;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'content',
        'user_id'
        
    ];
    public function post(){
        return $this->belongsTo(Post::class);
    }

    //Local Scope to get latest comments for a Post
    public function scopeLatestComments($query)
    {
        return $query->orderBy('updated_at', 'desc');
    }

    // public function scopeLatest(Builder $query){
    //    return $query->orderBy('updated_at', 'desc');
    // }


    // Scope to show posts order by 'desc' by using a global scope
    // public static function boot()
    // {
    //     parent::boot();

    //     static::addGlobalScope(new ShowLatest);

        
    // }

    public function user(){
        return $this->belongsTo(User::class);
    }


   
}
