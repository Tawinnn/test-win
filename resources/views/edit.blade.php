@extends('layouts.navbar')
@section('title', 'แก้ไขบทความ')
@section('content')
    <h2 class="text text-center py-2">แก้ไขบทความใหม่</h2>
    <form method="POST" action="{{ route('update', $blog->id) }}">
        @csrf
        <div class="form-group">
            <label for="">ชื่อบทความ</label>
            <input type="text" name="title" class="form-control" value="{{ $blog->title }}">
        </div>
        @error('title')
            <div class="my-2">
                <span class="text-danger">{{ $message }}</span>
            </div>
        @enderror
        <div>
            <label for="content">เนื้อหาบทความ</label>
            <textarea name="content" cols="30" rows="5" class="form-control">{{ $blog->content }}</textarea>
        </div>
        @error('content')
            <div class="my-2">
                <span class="text-danger">{{ $message }}</span>
            </div>
        @enderror
        <!-- แสดงรูปภาพที่อัปโหลดแล้ว -->
        <div class="mt-3">
            <label for="current-images">รูปภาพปัจจุบัน:</label>
            <div id="current-images" class="d-flex flex-wrap">
                @foreach ($blog->images as $image)
                    <div class="image-preview-wrapper m-2" style="position: relative;">
                        <img src="{{ asset('storage/' . $image->image) }}" class="img-thumbnail"
                            style="width: 150px; height: 150px;">
                        <form method="POST" action="{{ route('image.delete', $image->id) }}"
                            style="position: absolute; top: 5px; right: 5px;">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-sm">ลบ</button>
                        </form>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- อัปโหลดรูปภาพใหม่ -->
        <div class="mb-3">
            <label for="images">อัปโหลดรูปภาพใหม่</label>
            <input type="file" name="images[]" id="images" class="form-control" multiple
                onchange="previewNewImages()">
        </div>

        <!-- แสดงตัวอย่างรูปภาพใหม่ -->
        <div id="new-image-preview-container" class="mt-3 d-flex flex-wrap"></div>

        @error('images')
            <span class="text-danger">{{ $message }}</span>
        @enderror

        <input type="submit" value="อัปเดต" class="btn btn-primary my-2">
        <a href="/author/blog" class="btn btn-success">บทความทั้งหมด</a>
    </form>

    <!-- BEGIN: JS Assets-->
    <script>
        function previewNewImages() {
            const previewContainer = document.getElementById('new-image-preview-container');
            previewContainer.innerHTML = ''; // ลบภาพเก่าที่แสดงไว้

            const files = document.getElementById('images').files;

            Array.from(files).forEach((file) => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const div = document.createElement('div');
                    div.classList.add('image-preview-wrapper', 'm-2');

                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.classList.add('img-thumbnail');
                    img.style.width = '150px';
                    img.style.height = '150px';

                    div.appendChild(img);
                    previewContainer.appendChild(div);
                };
                reader.readAsDataURL(file);
            });
        }
    </script>
@endsection
