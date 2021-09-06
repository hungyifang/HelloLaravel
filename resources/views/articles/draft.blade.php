@extends('layouts.articles')

@section('title', '文章列表')

@section('main')
<div class="container mx-auto px-4 flex justify-between items-center">
    <h1 class="font-sans text-4xl mx-2 my-4">文章列表</h1>
    <div>
        <a href="{{ route('articles.create') }}" class="m-2 p-2 rounded bg-blue-500 hover:bg-blue-700 text-gray-50 font-bold no-underline text-base flex-none">新增文章</a>
    </div>
</div>
<div class="articles-wrapper container mx-auto px-20 my-4">
    <div class="flex justify-end items-center space-x-2">
        <a class="py-2 px-10 bg-indigo-100 hover:bg-purple-200 rounded font-semibold text-gray-400 hover:text-gray-700 transform translate-y-0 hover:translate-y-1 transition delay-100" href="{{ route('articles.index') }}">最新</a>
        <a class="py-2 px-10 bg-indigo-100 hover:bg-purple-200 rounded font-semibold text-gray-400 hover:text-gray-700 transform translate-y-0 hover:translate-y-1 transition delay-100" href="{{ route('articles.hot') }}">熱門</a>
        <div class="py-3 px-10 bg-indigo-500 rounded transform translate-y-1 text-gray-100 font-bold">我的草稿</div>
    </div>
    <div class="border-t-4 border-b-4 py-2 border-indigo-500">
        @foreach($articles as $index => $article)
        <div class="flex mx-auto items-center space-x-10 px-4 odd:bg-blue-100 even:bg-gray-50 rounded">
            {{-- <div class="text-2xl font-bold px-3 py-1 rounded">{{ $index+1 }}</div> --}}
        <div class="font-sans text-base py-3 text-center mx-3">
            <div>{{ $article->likes }}</div>
            <div class="font-thin">like</div>
        </div>
        <div class="font-sans text-base py-3 text-center mx-3">
            <div>{{ $article->viewed }}</div>
            <div class="font-thin">viewed</div>
        </div>
        <div class="py-3 mx-3">
            <a href="{{ route('articles.show', $article) }}">
                <div class="font-sans text-xl font-bold my-1 cursor-pointer">{{ $article->title }}</div>
            </a>
            <div class="font-sans text-xs font-thin my-1">{{ $article->created_at }} by
                <span class="text-blue-500 font-semibold">{{ $article->user->name }}</span>
            </div>
        </div>
    </div>
    @endforeach
</div>
<div class="py-2 px-2 my-3">{{ $articles->links() }}</div>

</div>
@endsection
