<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class AdminController extends Controller
{
    function index()
    {
        $blogs= DB::table('blogs')->get();
        return view('blog', compact('blogs'));
    }

    function about()
    {
        $name = "Radompon Duangta";
        $date = "27 มิถุนายน 2567";
        return view('about', compact('name', 'date'));
    }

    function create()
    {
        return view('form');
    }

    function insert(Request $request)
    {
        $request->validate(
            [
                'title' => 'required|max:50',
                'content' => 'required',
            ],
            [
                'title.required'=>'กรุณาใส่ชื่อบทความ',
                'title.max'=>'ชื่อบทความไม่ควรเกิน 50 ตัวอักษร',
                'content.required'=>'กรุณาใส่เนื้อหาบทความ'
            ]
        );
    }

    function delete($id)
    {
        dd($id);
    }
}
