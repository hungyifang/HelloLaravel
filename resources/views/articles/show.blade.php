@extends('layouts.articles')

@section('title', $article->title)

@section('main')
<div class="container mx-auto px-4 flex justify-between items-center">
    <div class="flex justify-between items-center">
        <h1 class="font-sans text-4xl mx-2 my-4">{{ $article->title }}</h1>
        @isset($userLike)
        @if($userLike->doLike === 1)
        <a href="{{ route('articles.like', $article) }}">
            <x-fas-heart class="w-8 h-8 fill-current text-pink-500" />
        </a>
        @else
        <a href="{{ route('articles.like', $article) }}">
            <x-far-heart class="w-8 h-8 fill-current text-pink-500" />
        </a>
        @endif
        @endisset
    </div>
</div>
<div class="px-4 mx-2 font-sans text-lg py-2">
    {{ $article->content }}
</div>
<div class="px-4 my-4 flex items-center">
    @if(isset($userID))
        @if($userID === $article->user_id)
        <div>
            <a href="{{ route('articles.edit', $article) }}" class="m-2 p-2 rounded bg-blue-500 hover:bg-blue-700 text-gray-50 font-bold no-underline text-base">編輯文章</a>
        </div>
        @else
        <div>
            <span class="m-2 p-2 rounded bg-gray-500 text-gray-50 font-bold no-underline text-base">編輯文章</span>
        </div>
        @endif
    @else
    <div>
        <span class="m-2 p-2 rounded bg-gray-500 text-gray-50 font-bold no-underline text-base">編輯文章</span>
    </div>
    @endif
    <div>
        <a href="{{ route('articles.index') }}" class="p-2 rounded bg-blue-500 hover:bg-blue-700 text-gray-50 font-bold no-underline text-base ">回列表</a>
    </div>


</div>
@endsection
