<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('main');
});

Route::get('about',function () {
    $name="Radompon Duangta";
    $date="27 มิถุนายน 2567";
    return view('about',compact('name','date'));
})->name('about');

Route::get('blog',function () {
    $blogs=[

        [
            'title'=>"บทความที่ 1",
            'content'=>'เนื้อหาบทความที่ 1',
            'status'=>true
        ],
        [
            'title'=>"บทความที่ 2",
            'content'=>'เนื้อหาบทความที่ 2',
            'status'=>false
        ],
        [
            'title'=>"บทความที่ 3",
            'content'=>'เนื้อหาบทความที่ 3',
            'status'=>true
        ],
    ];
    return view('blog',compact('blogs'));
})->name('blog');
