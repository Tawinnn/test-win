@extends('navbar')
@section('title', 'บทความ')
@section('content')
    @if (count($blogs)>0)
    <h2 class="text text-center py-2">บทความ</h2>
    <table class="table table-striped text-center">
        <thead>
            <tr class="table-warning">
                <th scope="col">ชื่อบทความ</th>
                {{-- <th scope="col">เนื้อหา</th> --}}
                <th scope="col">สถานะ</th>
                <th scope="col">แก้ไขบทความ</th>
                <th scope="col">ลบบทความ</th>
            </tr>
        </thead>
        <tbody>
            <tr class="table-group-divider">
                @foreach ($blogs as $item)
            <tr>
                <th scope="row">{{ $item->title }}</th>
                {{-- <td>{{Str::limit($item->content,30)}}</td> --}}
                <td>
                    @if ($item->status == true)
                        <a href="{{route('change',$item->id)}}" class="btn btn-success">เผยเเพร่</a>
                    @else
                        <a href="{{route('change',$item->id)}}" class="btn btn-warning">ฉบับร่าง</a>
                    @endif
                </td>
                <td>
                    <a href="{{route('edit',$item->id)}}" class="btn btn-info">แก้ไข</a>
                </td>
                <td>
                    <a href="{{route('delete',$item->id)}}"
                        class="btn btn-danger"
                        onclick="return confirm('คุณต้องการลบบทความ {{$item->title}} หรือไม่ ?')">
                        ลบ
                    </a>
                </td>
            </tr>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{$blogs->links()}}
    @else
    <h2 class="text text-center py-2">ไม่มีบทความในระบบ</h2>
    @endif
@endsection
