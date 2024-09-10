@extends('layouts.navbar')
@section('title')
    {{ $blog->title }}
@endsection
@section('content')
    <h2>{{ $blog->title }}</h2>
    <hr>
    <p>{{ $blog->content }}</p>
    <div class="mt-3">
        <label for="current-images">รูปภาพ:</label>
        <div id="current-images" class="d-flex flex-wrap">
            @foreach ($blog->images as $image)
                <div class="image-preview-wrapper m-2" style="position: relative;">
                    <a href="javascript:void(0);" onclick="showFullImage('{{ asset('storage/' . $image->image) }}')">
                        <img src="{{ asset('storage/' . $image->image) }}" class="img-thumbnail"
                            style="width: 200px; height: 200px;">
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



