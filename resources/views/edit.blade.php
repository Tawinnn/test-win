@extends('layouts.navbar')
@section('title', 'แก้ไขบทความ')
@section('content')
    <h2 class="text text-center py-2">แก้ไขบทความใหม่</h2>
    <form method="POST" action="{{ route('update', $blog->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT') <!-- เพิ่ม @method('PUT') -->
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
                        <a href="javascript:void(0);" onclick="showFullImage('{{ asset('storage/' . $image->image) }}')">
                            <img src="{{ asset('storage/' . $image->image) }}" class="img-thumbnail"
                                style="width: 150px; height: 150px;">
                            <input type="checkbox" name="delete_images[]" value="{{ $image->id }}"
                                style="position: absolute; top: 5px; right: 5px;">
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
        <!-- Fullscreen Image Modal -->
        <div id="imageModal" class="modal"
            style="display:none; position:fixed; z-index:1000; left:0; top:0; width:100%; height:100%; background-color:rgba(0,0,0,0.9);">
            <span id="closeModal"
                style="position:absolute; top:20px; right:30px; font-size:30px; cursor:pointer; color:white;">&times;</span>
            <img id="fullImage" style="margin:auto; display:block; max-width:80%; max-height:80%;">
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
                    div.style.position = 'relative';

                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.classList.add('img-thumbnail');
                    img.style.width = '150px';
                    img.style.height = '150px';

                    const removeBtn = document.createElement('button');
                    removeBtn.innerText = 'ลบ';
                    removeBtn.classList.add('btn', 'btn-danger', 'btn-sm');
                    removeBtn.style.position = 'absolute';
                    removeBtn.style.top = '5px';
                    removeBtn.style.right = '5px';
                    removeBtn.onclick = function() {
                        div.remove();
                        removeImage(index);
                    };

                    div.appendChild(img);
                    div.appendChild(removeBtn);
                    previewContainer.appendChild(div);
                };
                reader.readAsDataURL(file);
            });
        }
    </script>

    {{-- script --}}
    <script>
        function showFullImage(src) {
            var modal = document.getElementById("imageModal");
            var fullImage = document.getElementById("fullImage");
            modal.style.display = "block";
            fullImage.src = src;
        }

        // Close the modal when the 'x' is clicked
        document.getElementById("closeModal").onclick = function() {
            document.getElementById("imageModal").style.display = "none";
        }

        // Close the modal when clicked outside the image
        window.onclick = function(event) {
            var modal = document.getElementById("imageModal");
            if (event.target === modal) {
                modal.style.display = "none";
            }
        }
    </script>
@endsection
