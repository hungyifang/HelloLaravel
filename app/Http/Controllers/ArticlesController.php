<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ArticlesController extends Controller
{
    public function __construct()
    {
        //使用者有登入才能用以下路由 except (要除外的) only (只要使用在這的)
        $this->middleware('auth')->except('index', 'hot', 'show');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $article = \App\Models\Article::where('state', 'published');
        $updateLikes = $article->each(function ($value, $key) {
            $likes = \App\Models\Article::join('user_likes', function ($join) use ($value) {
                //join + where 要寫成函式型, 用 use 帶變數
                $join->on('articles.id', '=', 'user_likes.article_id')
                    ->where('doLike', true)
                    ->where('articles.id', $value->id);
            })->count();
            \App\Models\Article::find($value->id)->update(['likes' => $likes]);
        });
        $articles = \App\Models\Article::where('state', 'published')->orderBy('created_at', 'desc')->paginate(10);
        return view('articles.index', ['articles' => $articles]);

    }

    public function hot()
    {
        $article = \App\Models\Article::where('state', 'published');
        $updateLikes = $article->each(function ($value, $key) {
            $likes = \App\Models\Article::join('user_likes', function ($join) use ($value) {
                //join + where 要寫成函式型, 用 use 帶變數
                $join->on('articles.id', '=', 'user_likes.article_id')
                    ->where('doLike', true)
                    ->where('articles.id', $value->id);
            })->count();
            \App\Models\Article::find($value->id)->update(['likes' => $likes]);
        });
        $articles = \App\Models\Article::where('state', 'published')->orderBy('viewed', 'desc')->paginate(10);
        return view('articles.hot', ['articles' => $articles]);
    }

    public function draft()
    {
        $userID = auth()->id();
        $article = \App\Models\Article::where('state', 'draft');
        $updateLikes = $article->each(function ($value, $key) {
            $likes = \App\Models\Article::join('user_likes', function ($join) use ($value) {
                $join->on('articles.id', '=', 'user_likes.article_id')
                    ->where('doLike', true)
                    ->where('articles.id', $value->id);
            })->count();
            \App\Models\Article::find($value->id)->update(['likes' => $likes]);
        });
        $articles = \App\Models\Article::where('state', 'draft')->where('user_id', $userID)->paginate(10);
        return view('articles.draft', ['articles' => $articles]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('articles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request = $request->validate(
            ['title' => 'required', 'content' => 'required|min:10', 'state' => 'required']
        );

        auth()->user()->articles()->create($request);

        session()->flash('notice', '文章新增成功!'); // flash session 只會被取用一次就刪除

        return response(['url' => url('/articles')], 200);

        //使用 XHR 無法處理此部分轉址
        //laravel 原本處理方式
        // return redirect()->route('root')->with('notice', '文章新增成功!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $article = \App\Models\Article::find($id);
        //處理瀏覽數
        $newViewed = (\App\Models\Article::find($id)->viewed) + 1;
        $article->update(['viewed' => $newViewed]);
        //有登入回傳ID, 給我的最愛用
        if (auth()->check()) {
            $userID = auth()->id();
            $userLike = \App\Models\User_like::select('doLike')
                ->where('article_id', $id)
                ->where('user_id', $userID)
                ->first();
            // return $userLike;
            return view('articles.show', ['article' => $article, 'userLike' => $userLike, 'userID' => $userID]);
        };

        return view('articles.show', ['article' => $article]);
    }

    public function like($id)
    {
        $article = \App\Models\Article::find($id);
        $userID = auth()->id();
        $userLike = \App\Models\User_like::select('doLike', 'id')
            ->where('article_id', $id)
            ->where('user_id', $userID)
            ->first(); //用get會得到collection不是單一資料, 會造成無法得到欄位資料,找不到$userLike->doLike
        if (is_null($userLike)) {
            $newLike = ['article_id' => $id, 'user_id' => $userID, 'doLike' => false];
            \App\Models\User_like::create($newLike);
        } else {
            $doLike = !($userLike->doLike);
            \App\Models\User_like::find($userLike->id)->update(['doLike' => $doLike]);
        }
        return redirect()->route('articles.show', $article);
        // return $userLike;
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $article = \App\Models\Article::find($id);
        return view('articles.edit', ['article' => $article]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $article = \App\Models\Article::find($id);
        $request = $request->validate(
            ['title' => 'required', 'content' => 'required|min:10']
        );
        $article->update($request);
        $article->update(['state'=>'published']);
        session()->flash('notice', '文章更新成功!');
        return redirect()->route('articles.show', $article);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
