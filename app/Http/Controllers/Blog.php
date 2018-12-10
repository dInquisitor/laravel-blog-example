<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;
use App\Article;
use App\SubComment;

class Blog extends Controller {

    public function index() {
        $articles = Article::paginate(20);
        return view('allArticles', ['articles' => $articles]);
    }

    public function showArticle($slug) {
        $article = Article::where('link', $slug)->first();
        if ($article != null) {
            $article->times_viewed += 1;
            $article->save();
            $most_viewed_articles = Article::orderBy('times_viewed', 'desc')->limit(10)->get();
            return view('showArticle', [
                'article' => $article,
                'most_viewed_articles' => $most_viewed_articles
            ]);
        } else {
            abort(404);
        }
    }
    
    public function comment(Request $request, $article_id) {
        $article = Article::where('id', $article_id)->first();
        if($article != null){
        // it is recommended to check also for file size to avoid uploading large files as avatar image
        if($request->hasFile('avatar') && $request->file('avatar')->isValid() && 
                ($request->file('avatar')->getClientOriginalExtension() == 'png' ||
                $request->file('avatar')->getClientOriginalExtension() == 'jpg' ||
                $request->file('avatar')->getClientOriginalExtension() == 'jpeg')){
            $file = $request->file('avatar');
            $destinationPath = 'images';
            $destinationFileName = time().rand(0,999999).'.'.$file->getClientOriginalExtension();
            $file->move($destinationPath,$destinationFileName);
        }else{
            $destinationFileName = 'image.png';
        }
        $comment = new Comment;
        $comment->article_id = $article_id;
        $comment->name = $request->name;
        $comment->comment = $request->comment;
        $comment->image = $destinationFileName;
        $comment->save();
        return redirect('/article/'.$article->link);
        }else{
            abort(403);
        }
    }
    
    public function subcomment(Request $request, $comment_id, $article_id) {
        $article = Article::where('id', $article_id)->first();
        if($article != null){
            $comment = Comment::where('id', $comment_id)->first();
            if($comment != null){
                $subcomment = new SubComment;
                $subcomment->body = $request->comment;
                $subcomment->name = $request->name;
                $subcomment->comment_id = $comment_id;
                $subcomment->save();
                return redirect('/article/'.$article->link);
            }else{
                abort(403);
            }
        }else{
            abort(403);
        }
    }

}
