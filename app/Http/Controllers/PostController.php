<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\Filament\Post;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;

class PostController extends Controller
{
    public function show(Post $post)
    {
        $post->load('userFilament:id,name');
        return Inertia::render('Post/Show', [
            'post' => $post,
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
        ]);
    }
}
