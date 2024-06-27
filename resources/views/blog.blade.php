@extends('navbar')
@section('title', 'บทความ')

@section('content')
    <h2>บทความ</h2>
    <hr>
    @foreach ($blogs as $item)
        <h4> {{ $item['title'] }} </h4>
        <p> {{ $item['content'] }} </p>
        <hr>
    @endforeach

@endsection
