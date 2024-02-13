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
        $news = News::with(['auther', 'category', 'tags'])->where('slug', $slug)->ActiveEntries()->withLocalize()->first();
        $recentNews = News::with(['auther', 'category'])->where('slug', '!=', $news->slug)->ActiveEntries()->withLocalize()->orderBy('id', 'DESC')->take(4)->get();
        $this->countView($news);
        return view('frontend.news-details', compact('news', 'recentNews'));
    }

    /* Count News View */
    public function countView($news)
    {
        if(session()->has('viewed_news'))
        {
            $newsIds = session('viewed_news');
            if(!in_array($news->id, $newsIds))
            {
                $newsIds[] = $news->id;
                $news->increment('views');
            }
            session(['viewed_news' => $newsIds]);
        }
        else
        {
            session(['viewed_news' => [$news->id]]);
        }



    }
}
