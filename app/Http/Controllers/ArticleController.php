<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Events\NewArticleEvent;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */


    public function index()
    {
        $articles = Article::latest()->paginate(6);
        return view('article.index', ['articles'=> $articles]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('article.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', self::class);
        $request->validate([
            'date'=>'date',
            'name'=>'required|min:5|max:100',
            'desc'=>'required|min:5'
        ]);
        $article = new Article;
        $article->date = $request->date;
        $article->name = $request->name;
        $article->desc = $request->desc;
        $article->user_id = 1;
        if ($article->save()){
            NewArticleEvent::dispatch($article);
            return redirect('/article');
        }        
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article)
    {
        $comments = Comment::where('article_id',$article->id)
                                    ->where('accept', true)
                                    ->get();
        $user = User::findOrFail($article->user_id);
        return view('article.show', ['article'=>$article, 'user'=>$user, 'comments'=>$comments]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Article $article)
    {
        return view('article.update', ['article'=>$article]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Article $article)
    {
        $this->authorize('update', $article, self::class);
        $request->validate([
            'date'=>'date',
            'name'=>'required|min:5|max:100',
            'desc'=>'required|min:5'
        ]);
        $article->date = $request->date;
        $article->name = $request->name;
        $article->desc = $request->desc;
        $article->user_id = 1;
        if ($article->save()) return redirect('/article')->with('status','Update success');
        else return redirect()->route('article.index')->with('status','Update don`t success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        Gate::authorize('delete',$article);
        if ($article->delete()) return redirect('/article')->with('status','Delete success');
        else return redirect()->route('article.show', ['article'=>$article->id])->with('status','Delete don`t success');
    }
}
