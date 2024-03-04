<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminNewsCreateRequest;
use App\Http\Requests\AdminNewsUpdateRequest;
use App\Models\Category;
use App\Models\Language;
use App\Models\News;
use App\Models\Tag;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NewsController extends Controller
{
    use FileUploadTrait;

    public function __construct()
    {
        $this->middleware(['permission:news index,admin'])->only(['index', 'copyNews', 'toggleNewsStatus']);
        $this->middleware(['permission:news create,admin'])->only(['create', 'store']);
        $this->middleware(['permission:news update,admin'])->only(['edit', 'update']);
        $this->middleware(['permission:news delete,admin'])->only(['destroy']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $languages = Language::all();
        return view('admin.news.index', compact('languages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $languages = Language::all();
        return view('admin.news.create', compact('languages'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AdminNewsCreateRequest $request)
    {
        /* Handle The News Image */
        $imagePath = $this->handleFileUpload($request, 'image');

        $news = new News();
        $news->language = $request->language;
        $news->category_id = $request->category;
        $news->auther_id = Auth::guard('admin')->user()->id;
        $news->image = $imagePath;
        $news->title = $request->title;
        $news->slug = \Str::slug($request->title);
        $news->content = $request->content;
        $news->meta_title = $request->meta_title;
        $news->meta_description = $request->meta_description;
        $news->is_breaking_news = $request->is_breaking_news == 1 ? 1:0;
        $news->show_at_slider = $request->show_at_slider == 1 ? 1:0;
        $news->show_at_popular = $request->show_at_popular == 1 ? 1:0;
        $news->status = $request->status == 1 ? 1:0;
        $news->save();

        $tags = explode(',', $request->tags);
        $tagsId = [];
        foreach($tags as $tag)
        {
            $item = new Tag();
            $item->name = $tag;
            $item->language = $news->language;
            $item->save();
            $tagsId[] = $item->id;
        }
        $news->tags()->attach($tagsId);
        toast(__('Created Successfully'), 'success')->width('350');
        return redirect()->route('admin.news.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $languages = Language::all();
        $news = News::findOrFail($id);
        $categories = Category::where('language', $news->language)->get();
        return view('admin.news.edit', compact('languages', 'news','categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AdminNewsUpdateRequest $request, string $id)
    {
        $news = News::findOrFail($id);
        $imagePath = $this->handleFileUpload($request, 'image');
        $news->language = $request->language;
        $news->category_id = $request->category;
        $news->image = !empty($imagePath) ? $imagePath: $news->image;
        $news->title = $request->title;
        $news->slug = \Str::slug($request->title);
        $news->content = $request->content;
        $news->meta_title = $request->meta_title;
        $news->meta_description = $request->meta_description;
        $news->is_breaking_news = $request->is_breaking_news == 1 ? 1 : 0;
        $news->show_at_slider = $request->show_at_slider == 1 ? 1 : 0;
        $news->show_at_popular = $request->show_at_popular == 1 ? 1 : 0;
        $news->status = $request->status == 1 ? 1 : 0;
        $news->save();

        $tags = explode(',', $request->tags);
        $tagsId = [];

        /* Delete Previos Tags */
        $news->tags()->delete();

        /* Detach Tags Form Pivot Table */
        $news->tags()->detach($news->tags);

        foreach($tags as $tag)
        {
            $item = new Tag();
            $item->name = $tag;
            $item->language = $news->language;
            $item->save();
            $tagsId[] = $item ->id;
        }

        $news->tags()->attach($tagsId);
        toast(__('Update Successfully!'), 'success')->width('350');
        return redirect()->route('admin.news.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $news = News::findOrFail($id);
        $this->deleteFile($news->image);
        $news->tags()->delete();
        $news->delete();
        return response(['status' => 'success', 'message' => __('Deleted Successfully')]);

    }

    /**
     * Fetch The Category Depending On Language
     */
    public function fecthCategory(Request $request)
    {
        $categories = Category::where('language', $request->lang)->get();
        return $categories;
    }

    /* Change The Toggle Button Status */
    public function toggleNewsStatus(Request $request)
    {
        try
        {
            $news = News::findOrFail($request->id);
            $news->{$request->name} = $request->status;
            $news->save();
            return response(['status' => 'success', 'message'=> __('Updated Successfully')]);
        }
        catch(\Throwable $th)
        {
            throw $th;
        }

    }

    public function copyNews(string $id)
    {
        $news = News::findOrFail($id);
        $copyNews = $news->replicate();
        $copyNews->save();
        toast(__('Copied Successfully'), 'success');
        return redirect()->back();
    }

    public function pendingNews()
    {
        $languages = Language::all();
        return view('admin.pending-news.index', compact('languages'));
    }
}
