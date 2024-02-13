<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {

        $breakingNews = News::where(['is_breaking_news' => 1])->ActiveEntries()->withLocalize()
        ->orderBy('id','DESC')->take(10)->get();

        return view('frontend.home', compact('breakingNews'));
    }

    /* Show News Details */
    public function showNews($slug)
    {
        $news = News::with(['auther', 'category'])->where('slug', $slug)->ActiveEntries()->withLocalize()->first();
        return view('frontend.news-details', compact('news'));
    }
}
