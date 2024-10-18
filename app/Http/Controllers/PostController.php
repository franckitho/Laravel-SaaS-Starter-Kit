<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\Filament\Post;

class PostController extends Controller
{
    public function show(Post $post)
    {
        return Inertia::renderer('Post', ['post' => $post]);
    }
}
