<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Article;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Notifications\NewCommentNotify;
use App\Jobs\VeryLongJob;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;


class CommentController extends Controller
{

  public function index()
  {
      $page = request()->get('page', 1);
      $comments = Cache::remember('comments_page_' . $page, 60, function () {
          return Comment::latest()->paginate(10);
      });
      return view('comment.index', ['comments' => $comments]);
  }

  public function store(Request $request)
  {
      Cache::flush();
  
      $article = Article::findOrFail($request->article_id);
      $request->validate([
          'name' => 'required|min:4',
          'desc' => 'required|max:256'
      ]);
      $comment = new Comment;
      $comment->name = $request->name;
      $comment->desc = $request->desc;
      $comment->article_id = request('article_id');
      $comment->user_id = Auth::id();
  
      if ($comment->save()) {
          VeryLongJob::dispatch($comment, $article->name);
          return redirect()->route('article.show', $comment->article_id)->with('status', 'New comment send to moderation');
      }
  
      return redirect()->route('article.show', $comment->article_id)
          ->with('status', 'Add comment failed');
  }

    public function edit($id){
        $comment = Comment::findOrFail($id);
        Gate::authorize('update_comment', $comment);
        return view('comment.update',['comment'=>$comment]);
    }

    public function update(Request $request, Comment $comment)
{
    Cache::flush();

    Gate::authorize('update_comment', $comment);
    $request->validate([
        'name' => 'required|min:4',
        'desc' => 'required|max:256'
    ]);
    $comment->name = $request->name;
    $comment->desc = $request->desc;
    if ($comment->save()) return redirect()->route('article.show', $comment->article_id)->with('status', 'Comment update success');
    return redirect()->back()->with('status', 'Comment update failed');
}
    public function delete(Comment $comment){
        Cache::flush();
        Gate::authorize('update_comment', $comment);
        $comment->delete();
        return redirect()->back()->with('status', 'Comment delete success');
    }

    public function accept(Comment $comment)
{
    Cache::flush();

    $users = User::where('id', '!=', $comment->user_id)->get();
    $article = Article::findOrFail($comment->article_id);
    $comment->accept = true;
    if ($comment->save()) Notification::send($users, new NewCommentNotify($article, $comment->name));
    return redirect()->route('comment.index');
}

    public function reject(Comment $comment){
        Cache::flush();
        $comment->accept = false;
        $comment->save();
        return redirect()->route('comment.index');
    }
}
