<?php

namespace App\Http\Controllers;

use App\Models\Course;

class HomeController extends Controller
{
    public function index()
    {
        // Featured published courses for the homepage grid
        $courses = Course::published()
            ->with('category')
            ->where('is_featured', true)
            ->latest('published_at')
            ->take(6)
            ->get();

        // Pad with latest published if fewer than 6 featured
        if ($courses->count() < 6) {
            $ids  = $courses->pluck('id');
            $more = Course::published()
                ->with('category')
                ->whereNotIn('id', $ids)
                ->latest('published_at')
                ->take(6 - $courses->count())
                ->get();

            $courses = $courses->merge($more);
        }

        // ── Your views live under resources/views/pages/ ──────
        return view('pages.home', compact('courses'));
    }
}