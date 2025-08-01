@extends('layouts.app')
@section('content')
<div class="template-header">
    <div class="template-title-wrapper">
        <div class="template-title">JavaScript一覧</div>
        <a href="{{ route('jsCreate') }}" class="new-button">
            <img src="{{ asset('images/icon_add.png') }}" alt="新規登録" class="icon">
        </a>
    </div>
</div>
@if (session('success'))
    <div id="confomsg">{{ session('success') }}</div>
@endif
<table class="tablestyle-100">
    <thead>
        <tr>
            <th class="tb2-c">ID</th>
            <th class="tb2-c">タイトル</th>
            <th class="tb2-c">作成者</th>
            <th class="tb2-c">カテゴリコード</th>
        </tr>
    </thead>
    <tbody>
    @foreach($javascripts as $js)
        <tr>
            <td class="tb3-c">{{ $js->jsId }}</td>
            <td class="tb3-l">{{ $js->jsName }}</td>
            <td class="tb3-l">{{ $js->username }}</td>
            <td class="tb3-l"><pre>{{ $js->jsCode }}</pre></td>
        </tr>
    @endforeach
    </tbody>
</table>
@endsection
