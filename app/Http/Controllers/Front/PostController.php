<?php

declare(strict_types=1);

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Traits\HandlesSEO;

class PostController extends Controller
{
    use HandlesSEO;

    public function index(string $locale)
    {
        $this->setSeo([
            'title'       => __('public.title'),
            'description' => __('public.description.0'),
            'routeName'   => 'front.posts',
        ]);

        return view('front.posts.index', [
            'posts' => Post::all(),
        ]);
    }

    public function show(string $locale, string $slug)
    {
        $post = Post::findBy('slug', $slug);

        abort_unless($post, 404);

        $this->setSeo([
            'title'       => $post->title,
            'description' => $post->summary,
            'routeName'   => 'front.post',
            'routeArg'    => $slug,
        ]);

        return view('front.posts.show', [
            'post' => $post,
        ]);
    }
}
