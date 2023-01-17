<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class AdminController extends Controller
{
    public function index()
    {
        $articles = Article::where('status', 'pending')->get();
        $countUsers = User::all()->count();
        $pendingArticles = Article::where('status', 'pending')->count();
        $liveArticles = Article::where('status', 'live')->count();


        return view('admin.dashboard',
            compact('articles', 'countUsers', 'pendingArticles', 'liveArticles'));
    }

    public function users()
    {
        $users = User::all();
        return view('admin.users', compact('users'));
    }

    public function articles()
    {
        $articles = Article::all();
        return view('admin.articles', compact('articles'));
    }

    public function show(Article $article)
    {
        return view('admin.article.show', compact('article'));
    }

    public function toogleStatus(Article $article)
    {
        $article->status = $article->status === 'pending' ? 'live' : 'pending';
        $article->update();

        Mail::send('emails.status', ['article' => $article], function ($message) use ($article) {
            $message->to($article->user->email)->subject('Status of your article');
        });

        return response()->json(['status' => true, 'current' => $article->status]);
    }
}
