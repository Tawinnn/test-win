<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Blog;
use App\Models\BlogsImage;
use Illuminate\Support\Facades\Storage;


class AdminController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $blogs = Blog::paginate(10);
        return view('blog', compact('blogs'));
    }

    public function about()
    {
        $name = "Radompon Duangta";
        $date = "27 มิถุนายน 2567";
        return view('about', compact('name', 'date'));
    }

    public function create()
    {
        return view('form');
    }

    public function insert(Request $request)
    {
        $request->validate(
            [
                'title' => 'required|max:50',
                'content' => 'required',
                'images' => 'required',
                'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ],
            [
                'title.required' => 'กรุณาใส่ชื่อบทความ',
                'title.max' => 'ชื่อบทความไม่ควรเกิน 50 ตัวอักษร',
                'content.required' => 'กรุณาใส่เนื้อหาบทความ',
                'images.required' => 'กรุณาอัปโหลดรูปภาพ',
            ]
        );

        $blog = new Blog();
        $blog->title = $request->title;
        $blog->content = $request->content;
        $blog->save();

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('images', 'public');
                DB::table('blogs_images')->insert([
                    'blogs_id' => $blog->id,
                    'image' => $path,
                ]);
            }
        }

        return redirect('/author/blog');
    }

    public function delete($id)
    {
        // ค้นหาบทความที่ต้องการลบ
        $blog = Blog::find($id);

        // ตรวจสอบว่าบทความนี้มีรูปภาพที่เกี่ยวข้องหรือไม่
        $images = DB::table('blogs_images')->where('blogs_id', $blog->id)->get();

        if ($images) {
            // ลบไฟล์รูปภาพออกจาก storage
            foreach ($images as $image) {
                if (Storage::disk('public')->exists($image->image)) {
                    Storage::disk('public')->delete($image->image);
                }
            }

            // ลบข้อมูลรูปภาพที่เกี่ยวข้องในฐานข้อมูล
            DB::table('blogs_images')->where('blogs_id', $blog->id)->delete();
        }

        // ลบบทความ
        $blog->delete();

        return redirect()->back();
    }


    public function change($id)
    {
        $blog = Blog::find($id);
        $data = [
            'status' => !$blog->status
        ];
        $blog = Blog::find($id)->update($data);
        return redirect()->back();
    }

    public function edit($id)
    {
        $blog = Blog::find($id);
        return view('edit', compact('blog'));
    }

    public function update(Request $request, $id)
    {
        $request->validate(
            [
                'title' => 'required|max:50',
                'content' => 'required',
                'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ],
            [
                'title.required' => 'กรุณาใส่ชื่อบทความ',
                'title.max' => 'ชื่อบทความไม่ควรเกิน 50 ตัวอักษร',
                'content.required' => 'กรุณาใส่เนื้อหาบทความ',
            ]
        );

        $blog = Blog::find($id);
        $blog->update([
            'title' => $request->title,
            'content' => $request->content,
        ]);

        // อัปโหลดรูปภาพใหม่
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('images', 'public');
                BlogsImage::create([
                    'blogs_id' => $blog->id,
                    'image' => $path,
                ]);
            }
        }

        return redirect('/author/blog');
    }

    public function deleteImage($id)
    {
        $image = BlogsImage::find($id);

        // ลบไฟล์จาก storage
        if (Storage::disk('public')->exists($image->image)) {
            Storage::disk('public')->delete($image->image);
        }

        // ลบข้อมูลรูปภาพจากฐานข้อมูล
        $image->delete();

        return redirect()->back();
    }
}
