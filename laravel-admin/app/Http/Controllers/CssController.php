<?php
// CssController.php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CssController extends Controller
{
    public function index()
    {
        $csses = DB::table('csses')
            ->leftJoin('users', 'csses.userId', '=', 'users.id')
            ->select(
                'csses.*',
                'users.name as username'
            )
            ->orderBy('csses.cssUpdatedAt', 'desc')
            ->get();

        return view('cssList', compact('csses'));
    }

    public function create()
    {
        return view('cssCreate');
    }

    public function store(Request $request)
    {
        $request->validate([
            'cssName' => 'required|string|max:255',
            'cssCode' => 'required|string',
            'cssContent' => 'string',
        ]);

        DB::table('csses')->insert([
            'cssName' => $request->input('cssName'),
            'cssCode' => $request->input('cssCode'),
            'cssContent' => $request->input('cssContent'),
            'userId' => Auth::id(),
            'cssCreatedAt' => now(),
            'cssUpdatedAt' => now(),
        ]);

        return redirect()->route('cssList');
    }
}
