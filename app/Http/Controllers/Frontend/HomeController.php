<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Mail\ContactMail;
use App\Models\About;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Contact;
use App\Models\HomeSectionSetting;
use App\Models\News;
use App\Models\RecivedMail;
use App\Models\SocialCount;
use App\Models\SocialLink;
use App\Models\Subscriber;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
    public function index()
    {

        $breakingNews = News::where(['is_breaking_news' => 1])->activeEntries()->withLocalize()
            ->orderBy('updated_at', 'DESC')->take(10)->get();

        $heroSlider = News::with(['category', 'auther'])->where(['show_at_slider' => 1])->activeEntries()->withLocalize()
            ->orderBy('updated_at', 'DESC')->take(6)->get();

        $recentNews = News::with(['category', 'auther'])->activeEntries()->withLocalize()
            ->orderBy('updated_at', 'DESC')->take(6)->get();

        $popularNews = News::with(['category'])->where(['show_at_popular' => 1])->activeEntries()->withLocalize()
            ->orderBy('updated_at', 'DESC')->take(4)->get();

        $HomeSectionSetting = HomeSectionSetting::where(['language' => getLanguage()])->first();

        if ($HomeSectionSetting) {
            $categorySectionOne = News::where('category_id', $HomeSectionSetting->category_section_one)
                ->activeEntries()->withLocalize()->orderBy('id', 'DESC')->take(10)->get();

            $categorySectionTwo = News::where('category_id', $HomeSectionSetting->category_section_two)
                ->activeEntries()->withLocalize()->orderBy('id', 'DESC')->take(10)->get();

            $categorySectionThree = News::where('category_id', $HomeSectionSetting->category_section_three)
                ->activeEntries()->withLocalize()->orderBy('id', 'DESC')->take(10)->get();

            $categorySectionFour = News::where('category_id', $HomeSectionSetting->category_section_four)
                ->activeEntries()->withLocalize()->orderBy('id', 'DESC')->take(10)->get();
        } else {
            $categorySectionOne = collect();
            $categorySectionTwo = collect();
            $categorySectionThree = collect();
            $categorySectionFour = collect();
        }

        $mostViewedPosts = News::activeEntries()->withLocalize()->orderBy('views', 'DESC')->take(3)->get();

        $socialCounts = SocialCount::where(['status' => 1, 'language' => getLanguage()])->get();

        $mostCommonTags = $this->mostCommonTags();

        return view('frontend.home', compact(
            'breakingNews',
            'heroSlider',
            'recentNews',
            'popularNews',
            'categorySectionOne',
            'categorySectionTwo',
            'categorySectionThree',
            'categorySectionFour',
            'mostViewedPosts',
            'socialCounts',
            'mostCommonTags'
        ));
    }

    /* Show News Details */
    public function showNews($slug)
    {
        $news = News::with(['auther', 'category', 'tags', 'comments'])->where('slug', $slug)
            ->activeEntries()->withLocalize()->first();
        $this->countView($news);

        $recentNews = News::with(['auther', 'category'])->where('slug', '!=', $news->slug)
            ->activeEntries()->withLocalize()->orderBy('id', 'DESC')->take(4)->get();

        $mostCommonTags = $this->mostCommonTags();

        $nextNews = News::where('id', '>', $news->id)->activeEntries()
            ->withLocalize()->orderBy('id', 'asc')->first();

        $previousNews = News::where('id', '<', $news->id)->activeEntries()
            ->withLocalize()->orderBy('id', 'desc')->first();

        $relatedNews = News::where('slug', '!=', $news->slug)->where('category_id', $news->category_id)
            ->activeEntries()->withLocalize()->take(5)->get();

        $socialCounts = SocialCount::where(['status' => 1, 'language' => getLanguage()])->get();



        return view('frontend.news-details', compact('news', 'recentNews', 'mostCommonTags', 'nextNews', 'previousNews', 'relatedNews', 'socialCounts'));
    }

    /* Count News View */
    public function countView($news)
    {
        if (session()->has('viewed_news')) {
            $newsIds = session('viewed_news');
            if (!in_array($news->id, $newsIds)) {
                $newsIds[] = $news->id;
                $news->increment('views');
            }
            session(['viewed_news' => $newsIds]);
        } else {
            session(['viewed_news' => [$news->id]]);

            $news->increment('views');
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

        $comment = new Comment();
        $comment->news_id = $request->news_id;
        $comment->user_id = Auth::user()->id;
        $comment->parent_id = $request->parent_id;
        $comment->comment = $request->comment;
        $comment->save();
        toast(__('frontend.Comment added successfully'), 'success');
        return redirect()->back();
    }

    /* Handle Replay On A Comment */
    public function handleReplay(Request $request)
    {
        $request->validate([
            'replay' => ['required', 'string', 'max:1000']
        ]);

        $comment = new Comment();
        $comment->news_id = $request->news_id;
        $comment->user_id = Auth::user()->id;
        $comment->parent_id = $request->parent_id;
        $comment->comment = $request->replay;
        $comment->save();
        toast(__('frontend.Comment added successfully'), 'success');
        return redirect()->back();
    }

    public function commentDestory(Request $request)
    {
        $comment = Comment::findOrFail($request->id);
        if (Auth::user()->id == $comment->user_id) {
            $comment->delete();
            return response(['status' => 'success', 'message' => __('frontend.Deleted Successfully')]);
        }
        return response(['status' => 'error', 'message' => __('frontend.Someting went wrong')]);
    }

    /* Show The News Depending on Searching */
    public function news(Request $request)
    {
        $news = News::query();

        $news->when($request->has('tag'), function ($query) use ($request) {
            $query->whereHas('tags', function ($query) use ($request) {
                $query->where('name', $request->tag);
            });
        });

        $news->when($request->has('category') && !empty($request->category), function ($query) use ($request) {
            $query->whereHas('category', function ($query) use ($request) {
                $query->where('slug', $request->category);
            });
        });

        $news->when($request->has('search'), function ($query) use ($request) {
            $query->where(function ($query) use ($request) {
                $query->where('title', 'like', '%' . $request->search . '%')
                    ->orWhere('content', 'like', '%' . $request->search . '%');
            })
                ->orWhereHas('category', function ($query) use ($request) {
                    $query->where('name', 'like', '%' . $request->search . '%');
                });
        });

        $news = $news->activeEntries()->withLocalize()->paginate(10);


        $recentNews = News::with(['auther', 'category'])
            ->activeEntries()->withLocalize()->orderBy('id', 'DESC')->take(4)->get();

        $mostCommonTags = $this->mostCommonTags();

        $categories = Category::where(['status' => 1, 'language' => getLanguage()])->get();

        return view('frontend.news', compact('news', 'recentNews', 'mostCommonTags', 'categories'));
    }

    public function SubscribeNewsLetter(Request $request)
    {
        $request->validate(
            [
                'email' => ['required', 'email', 'max:255', 'unique:subscribers,email']
            ],
            [
                'email.unique' => 'Email is already subscribed'
            ]
        );
        $subscriber = new Subscriber();
        $subscriber->email = $request->email;
        $subscriber->save();
        return response(['status' => 'success', 'message' => 'Subscribed successfully']);

    }

    public function about()
    {
        $about = About::where('language', getLanguage())->first();
        return view('frontend.about', compact('about'));
    }

    public function contact()
    {
        $contact = Contact::where('language', getLanguage())->first();
        $socials = SocialLink::where('status', 1)->get();
        return view('frontend.contact', compact('contact', 'socials'));
    }

    public function handleContactForm(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'max:255'],
            'subject' => ['required', 'max:255'],
            'message' => ['required', 'max:500']
        ]);

        try
        {
            $toMail = Contact::where('language', 'en')->first();

            /* Send Email */
            Mail::to($toMail->email)->send(new ContactMail($request->subject , $request->message, $request->email));

            $mail = new RecivedMail();
            $mail->email = $request->email;
            $mail->subject = $request->subject;
            $mail->message = $request->message;
            $mail->save();
        }
        catch (\Throwable $th)
        {
            toast(__($th->getMessage()));
        }

        toast(__('frontend.Message sent successfully'), 'success');
        return redirect()->back();
    }
}
