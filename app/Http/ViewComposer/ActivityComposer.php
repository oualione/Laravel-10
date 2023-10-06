<?php

namespace App\Http\ViewComposer;

use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class ActivityComposer {
    public function compose(View $view)
    {
        $mostCommentedPost = Cache::remember('most_commented', now()->addSeconds(10), function () {
            return Post::mostCommentedPost()->take(3)->get();
        });


        // $mostCommentedPost = Post::mostCommentedPost()->take(3)->get();
        $mostActiveUser = User::mostActivatedUser()->take(3)->get();
        $mostActiveUserLastMonth = User::mostActivatedUserLastMonth()->take(3)->get();

        $view->with([
                    'mostCommentedPost' => $mostCommentedPost,
                    'mostActiveUser' => $mostActiveUser,
                    'mostActiveUserLastMonth' => $mostActiveUserLastMonth,
                    ]);
    }

}


?>