<?php
// app/Http/Controllers/TemplateController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;


class TemplateController extends Controller
{
    public function index()
    {
        $templates = DB::table('templates')
            ->leftJoin('users', 'templates.userId', '=', 'users.id')
            ->leftJoin('csses', 'templates.cssId', '=', 'csses.cssId')
            ->leftJoin('javascripts', 'templates.jsId', '=', 'javascripts.jsId')
            ->select(
                'templates.*',
                'users.name as username',
                'csses.cssName',
                'csses.cssCode',
                'javascripts.jsName',
                'javascripts.jsCode'
            )
            ->orderBy('templates.tmpupdatedatetime', 'desc')
            ->get();

        return view('templateList', compact('templates'));
    }

    public function create()
    {
        $csses = DB::table('csses')->get();
        $javascripts = DB::table('javascripts')->get();
        return view('templateCreate', compact('csses', 'javascripts'));
    }

    public function store(Request $request)
    {

        // テンプレート作成処理
        $vali = $request->validate([
            'tmpcode' => 'required|string|max:50|unique:templates,tmpcode',
            'tmpname' => 'required|string|max:100',
            'tmphtml' => 'required|string',
            'cssId'  => 'nullable|integer|exists:csses,cssId',
            'jsId'  => 'nullable|integer|exists:javascripts,jsId',
        ]);

        $result = array_merge($vali, [
            'userId' => Auth::id(),
            'tmpcreatedatetime' => now(),
            'tmpupdatedatetime' => now(),
        ]);
        DB::table('templates')->insert($result);

        return redirect()->route('templateList')->with('success', 'テンプレートを作成しました');
    }
    public function show($id)
    {
        $template = DB::table('templates')
            ->leftJoin('users', 'templates.userId', '=', 'users.id')
            ->leftJoin('csses', 'templates.cssId', '=', 'csses.cssId')
            ->leftJoin('javascripts', 'templates.jsId', '=', 'javascripts.jsId')
            ->select(
                'templates.*',
                'users.name as username',
                'csses.cssName as cssName',
                'javascripts.jsName as jsName'
            )
            ->where('templates.tmpId', $id)
            ->first();

        if (!$template) {
            abort(404);
        }

        return view('templateShow', compact('template'));
    }

    public function edit($id)
    {
        $template = DB::table('templates')->where('tmpId', $id)->first();
        if (!$template) abort(404);

        $csses = DB::table('csses')->get();
        $javascripts = DB::table('javascripts')->get();

        return view('templateEdit', compact('template', 'csses', 'javascripts'));
    }


    public function update(Request $request, $id)
    {
        $exist = DB::table('templates')->where('tmpId',$id);
        if (!($exist->exists())) {
            abort(Response::HTTP_NOT_FOUND);

        }
        // テンプレート更新処理
        $validated = $request->validate([
            'tmpcode' => 'required|string|max:50|unique:templates,tmpcode,' . $id . ',tmpId',
            'tmpname' => 'required|string|max:100',
            'tmphtml' => 'required|string',
            'cssId'  => 'nullable|integer|exists:csses,cssId',
            'jsId'  => 'nullable|integer|exists:javascripts,jsId',
        ]);

        $validated['tmpupdatedatetime'] = now();

        $exist->update($validated);

        return redirect()->route('templateList')->with('success', 'テンプレートを更新しました');
    }


}

