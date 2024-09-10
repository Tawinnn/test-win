@extends('layouts.navbar')
@section('title', 'หน้าเเรก')

@section('content')
    <h2>บทความล่าสุด</h2>
    <hr>
    @foreach ($blogs as $item)
    <h2>{{$item->title}}</h2>
    <p>{{Str::limit($item->content,150  )}}</p>
    <a href="/detail/{{$item->id}}">อ่านเพิ่มเติม</a>
    <hr>
    @endforeach
@endsection
