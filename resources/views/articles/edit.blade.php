@extends('layouts.articles')

@section('title', '新增文章')

@section('main')
<h1 class="font-sans text-4xl mx-2 my-4">編輯文章</h1>
{{-- 印錯誤訊息 --}}
{{-- AJAX 錯誤訊息會以 JSON 回傳,用 DOM append 處理 --}}
<div id="error-box">
    {{-- 原生表單錯誤處理 laravel 可以直接 render --}}
    @if($errors->any())
    <div class="errors p-3 bg-red-400 text-red-50 rounded fixed top-0 w-full flex justify-between items-center" id="msg-box">
        <ul class="list-none font-bold text-base font-sans">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
        <x-fontisto-close class="w-6 h-6" id="btn-close" />
    </div>
    @endif
</div>
{{-- 表單 --}}
<form action="{{ route('articles.update', $article) }}" method="post" class="mx-2" id="create-article">
    {{-- csrf token --}}
    @csrf
    @method('patch')
    <div class="py-2">
        <label for="" class="p-2 my-2">標題 :</label><br />
        <input type="text" name="title" class="border border-gray-500 m-2 font-sans" value="{{ $article->title }}" required />
    </div>
    <div class="py-2">
        <label for="" class="p-2 my-2">內文 :</label><br />
        <textarea name="content" id="" cols="30" rows="10" class="border border-gray-500 m-2 font-sans" required minlength="10">{{ $article->content }}</textarea>
    </div>
    <div>
        @if($article->state==="draft")
        <button type="submit" class="m-2 p-2 rounded border-none bg-blue-500 hover:bg-blue-700 text-gray-50 font-bold text-base" id="btn-draft">儲存並發布</button>
        @else
        <button type="submit" class="m-2 p-2 rounded border-none bg-blue-500 hover:bg-blue-700 text-gray-50 font-bold text-base" id="btn-draft">儲存</button>
        @endif
    </div>
</form>
@endsection

@section('js')
{{-- <script src="{{ asset('js/articles_create.js') }}" defer></script> --}}
@endsection
