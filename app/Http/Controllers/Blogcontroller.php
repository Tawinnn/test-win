<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;

class Blogcontroller extends Controller
{
    public function index()
    {
        $blogs=Blog::orderByDesc('id')->where('status',true)->get();
        return view('main',compact('blogs'));
    }

    public function detail($id)
    {
        $blog=Blog::find($id);
        return view('detail',compact('blog'));
    }
}
