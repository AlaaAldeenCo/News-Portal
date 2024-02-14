<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $mostCommonTags = $this->mostCommonTags();
        $this->countView($news);
        return view('frontend.news-details', compact('news', 'recentNews', 'mostCommonTags'));
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

    /* Getting The Most Common Tags */
    public function mostCommonTags()
    {
        return Tag::select('name', DB::raw('COUNT(*) as count'))->where('language', getLanguage())
        ->groupBy('name')->orderByDesc('count')->take(10)->get();
    }

    /* Handle Comment */
    public function handleComment(Request $request)
    {
        $request->validate([
            'comment' => ['required', 'string', 'max:1000']
        ]);
    }
}
