<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Bid;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::where('status', 'live')->get();
        return view('dashboard', compact('articles'));
    }

    public function myArticles()
    {
        $articles = Article::where('user_id', Auth::user()->id)->get();
        return view('my-articles', compact('articles'));
    }

    public function create()
    {
        return view('articles.create');
    }

    public function edit(Article $article)
    {
        return view('articles.edit', compact('article'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'body' => 'required',
            'min_price' => 'required|numeric',
            'end_time' => 'required',
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $article = new Article();
        $article->title = $validatedData['title'];
        $article->body = $validatedData['body'];
        $article->min_price = $validatedData['min_price'];
        $article->end_time = $validatedData['end_time'];
        $article->user_id = Auth::user()->id;

        $article->save();

        if($request->hasFile('images')) {
            $images = $request->file('images');

            foreach ($images as $image) {
                $path = $image->store('storage', 'public');
                $img = new Image();
                $img->image_path = $path;
                $img->article_id = $article->id;
                $img->save();
            }
        }

        return redirect()->route('article.mine')->with('status', 'Article created!');
    }

    public function update(Article $article, Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'body' => 'required',
            'min_price' => 'required|numeric',
            'end_time' => 'required',
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $article->title = $validatedData['title'];
        $article->body = $validatedData['body'];
        $article->min_price = $validatedData['min_price'];
        $article->end_time = $validatedData['end_time'];

        $article->update();

        if($request->hasFile('images')) {
            $images = $request->file('images');

            foreach ($images as $image) {
                $path = $image->store('storage', 'public');
                $img = new Image();
                $img->image_path = $path;
                $img->article_id = $article->id;
                $img->save();
            }
        }

        return redirect()->route('article.mine')->with('status', 'Article created!');
    }

    public function bid(Request $request)
    {
        $articleId = $request->input('article_id');
        $bidPrice = $request->input('bid_price');

        $bid = new Bid();
        $bid->bid_price = $bidPrice;
        $bid->article_id = $articleId;
        $bid->user_id = Auth::user()->id;

        $bid->save();

        return response()->json(['status' => true, 'articleId' => $articleId, 'bidPrice' => $bidPrice]);
    }

    public function show(Article $article)
    {
        return view('article.show', compact('article'));
    }

}
