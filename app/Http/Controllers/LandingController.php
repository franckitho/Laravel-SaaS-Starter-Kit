<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\Filament\Post;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;

class LandingController extends Controller
{
    public function index()
    {
        $posts = Post::with('userFilament:id,name')
                    ->orderBy('created_at', 'desc')
                    ->published()
                    ->select('title', 'slug', 'seo_description', 'created_at', 'cover_filename', 'user_filament_id')
                    ->limit(3)
                    ->get();

        return Inertia::render('Welcome', [
            'posts' => $posts,
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
        ]);
    }
}
