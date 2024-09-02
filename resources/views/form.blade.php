@extends('layouts.navbar')
@section('title', 'เขียนบทความ')

<style>
    .image-preview-wrapper {
        position: relative;
        display: inline-block;
    }

    .image-preview-wrapper img {
        border-radius: 8px;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
    }

    .image-preview-wrapper button {
        position: absolute;
        top: 5px;
        right: 5px;
        background-color: rgba(255, 0, 0, 0.7);
        border: none;
        color: white;
        padding: 2px 6px;
        cursor: pointer;
    }

    .image-preview-wrapper button:hover {
        background-color: red;
    }
</style>

@section('content')
    <h2 class="text text-center py-2">เขียนบทความใหม่</h2>
    <form method="POST" action="/author/insert" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="">ชื่อบทความ</label>
            <input type="text" name="title" class="form-control">
        </div>
        @error('title')
            <div class="my-2">
                <span class="text-danger">{{ $message }}</span>
            </div>
        @enderror
        <div>
            <label for="content">เนื้อหาบทความ</label>
            <textarea name="content" cols="30" rows="5" class="form-control"></textarea>
        </div>
        @error('content')
            <div class="my-2">
                <span class="text-danger">{{ $message }}</span>
            </div>
        @enderror
        <div class="mb-3">
            <label for="images">Upload File/Image</label>
            <input type="file" name="images[]" id="images" class="form-control" multiple onchange="previewImages()">
            @error('images')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <!-- Container to display image previews -->
        <div id="image-preview-container" class="mt-3 d-flex flex-wrap"></div>


        <input type="submit" value="บันทึก" class="btn btn-primary my-2">
        <a href="/author/blog" class="btn btn-success">บทความทั้งหมด</a>
    </form>



    
<!-- BEGIN: JS Assets-->
    <script>
        function previewImages() {
            const previewContainer = document.getElementById('image-preview-container');
            previewContainer.innerHTML = ''; // Clear previous images

            const files = document.getElementById('images').files;

            Array.from(files).forEach((file, index) => {
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

        function removeImage(index) {
            const files = document.getElementById('images').files;
            const dt = new DataTransfer();

            // Loop through files and append files that are not removed
            Array.from(files).forEach((file, i) => {
                if (index !== i) {
                    dt.items.add(file);
                }
            });

            // Update input files
            document.getElementById('images').files = dt.files;
            previewImages(); // Refresh preview
        }
    </script>
@endsection
