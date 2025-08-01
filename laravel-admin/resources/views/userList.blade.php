@extends('layouts.app')
@section('content')
<div class="template-header">
    <div class="template-title">ユーザー一覧</div>
    <a href="{{ route('userCreate') }}" class="new-button">
        <img src="{{ asset('images/icon_add.png') }}" alt="新規登録" class="icon">
    </a>
</div>
@if (session('success'))
    <div id="confomsg">{{ session('success') }}</div>
@endif
<table class="tablestyle-100">
    <thead>
        <tr>
            <th class="tb2-c">ID</th>
            <th class="tb2-c">名前</th>
            <th class="tb2-c">メールアドレス</th>
        </tr>
    </thead>
    <tbody>
    @foreach($users as $user)
        <tr>
            <td class="tb3-c">{{ $user->id }}</td>
            <td class="tb3-l">{{ $user->name }}</td>
            <td class="tb3-l">{{ $user->email }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
@endsection
