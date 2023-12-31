<?php

namespace App\Providers;

use App\Policies\PostPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        'App\Models\User' => 'App\Policies\UserPolicy',

    ];

    

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // Gate::define('post.update', function($user, $post){
        //     return $user->id === $post->user_id;
        // });

        // Gate::define('post.edit', function ($user, $post) {
        //     return $user->id === $post->user_id;
        // });

        // Gate::define('post.delete', function ($user, $post) {
        //     return $user->id === $post->user_id;
        // });

        Gate::define('secret.page', function($user){
            if($user->is_admin){
                return true;
            }
        });

        Gate::resource('post', PostPolicy::class);



        


        Gate::before(function($user, $ability){
            if($user->is_admin && in_array($ability, ['edit', 'update', 'delete'])){
                return true;
            }
        });

        //
    }
}
