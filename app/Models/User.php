<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function post(){
        return $this->hasMany(Post::class);
    }

    public function scopeMostActivatedUser($query){
        return $query->withCount('post')->orderBy('post_count', 'desc');
    }

    // Scope to show Most active users last Month
    public function scopeMostActivatedUserLastMonth($query){
        return $query->withCount(['post' => function($query){
            $query->whereBetween(static::UPDATED_AT, [now()->subMonth(1), now()]);
        }
     ])->having('post_count', '>' , 13)
     ->orderBy('post_count', 'desc');
    }

    //  we change this relation from one to many to Morph one to many
    // public function comments(){
    //     return $this->hasMany(Comment::class);
    // }

    public function comments() : MorphMany {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function image() : MorphOne
    {
        return $this->morphOne(Image::class, 'imageable');
    }
}
