<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class JsController extends Controller
{
    // 一覧表示
    public function index()
    {
        $javascripts = DB::table('javascripts')
            ->leftJoin('users', 'javascripts.userId', '=', 'users.id')
            ->select('javascripts.*', 'users.name as username')
            ->orderBy('javascripts.jsUpdatedAt', 'desc')
            ->get();

        return view('jsList', compact('javascripts'));
    }

    // 新規作成フォーム表示
    public function create()
    {
        return view('jsCreate');
    }

    // 登録処理
    public function store(Request $request)
    {
        $request->validate([
            'jsName' => 'required|string|max:255',
            'jsCode' => 'required|string',
            'jsContent' => 'required|string',
        ]);

        $id = DB::table('javascripts')->insertGetId([
            'jsName' => $request->input('jsName'),
            'jsCode' => $request->input('jsCode'),
            'jsContent' => $request->input('jsContent'),
            'userId' => Auth::id(),
            'jsCreatedAt' => now(),
            'jsUpdatedAt' => now(),
        ]);

        return redirect()->route('jsList')->with('success', 'JavaScriptを登録しました。ID:' . $id);
    }
}
