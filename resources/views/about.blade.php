@extends('navbar')
@section('title','เกี่ยวกับเรา')

@section('content')
<h2>เกี่ยวกับเรา</h2>
<hr>
<p>ผู้พัฒนาระบบ : {{$name}}</p>
<p>วันเริ่มต้นโปรเจกด์ : {{$date}}</p>
@endsection