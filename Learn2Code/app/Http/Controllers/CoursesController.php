<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Storage;
use Illuminate\Pagination\Paginator;
use App\Models\CoursesModel;

class CoursesController extends Controller
{
    // ================= FRONTEND =================
public function frontend(Request $request)
{
    try {
        $q         = trim((string)$request->query('q', ''));
        $level     = $request->query('level');
        $language  = $request->query('language');
        $priceType = $request->query('price_type');
        $provider  = $request->query('provider');   // << เพิ่ม
        $sort      = $request->query('sort','latest');

        $query = CoursesModel::query();

        if($q !== ''){
            $query->where(function($w) use ($q){
                $w->where('title','like',"%{$q}%")
                  ->orWhere('description','like',"%{$q}%")
                  ->orWhere('provider','like',"%{$q}%");
            });
        }

        if(!empty($level))     $query->where('level',$level);
        if(!empty($language))  $query->where('language',$language);
        if(!empty($priceType)) $query->where('price_type',$priceType);
        if(!empty($provider))  $query->where('provider',$provider);   // << เพิ่ม

        switch($sort){
            case 'price_asc':   $query->orderBy('price','asc'); break;
            case 'price_desc':  $query->orderBy('price','desc'); break;
            case 'rating_desc': $query->orderBy('avg_rating','desc'); break;
            default:            $query->orderBy('course_id','desc');
        }

        $courses = $query->paginate(12)->withQueryString();
        return view('layouts.frontend', compact('courses'));
    } catch (\Exception $e) {
        return view('errors.404');
    }
}

    // ================= INDEX =================
    public function index()
    {
        Paginator::useBootstrap();
        $courses = CoursesModel::orderBy('course_id', 'desc')->paginate(5);
        return view('courses.list', compact('courses'));
    }

    // ================= FORM ADD =================
    public function adding()
    {
        return view('courses.create');
    }

    // ================= CREATE =================
    public function create(Request $request)
    {
        $messages = [
            'title.required' => 'กรุณากรอกชื่อคอร์ส',
            'provider.required' => 'กรุณากรอกผู้ให้บริการ',
            'price_type.required' => 'กรุณาเลือกประเภทการใช้งาน',
            'price.numeric' => 'กรุณากรอกราคาเป็นตัวเลข',
            'cover_img.mimes' => 'รองรับ jpeg, png, jpg เท่านั้น',
            'cover_img.max' => 'ขนาดไฟล์ไม่เกิน 5MB',
        ];

        $validator = Validator::make($request->all(), [
            'title' => 'required|min:3|max:200',
            'category_id' => 'required|integer',
            'provider' => 'required|max:120',
            'provider_instructor' => 'nullable|max:120',
            'level' => 'nullable|max:20',
            'language' => 'nullable|max:50',
            'price_type' => 'required|max:10',
            'price' => 'nullable|numeric|min:0',
            'duration_text' => 'nullable|max:60',
            'description' => 'nullable',
            'cover_img' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'course_url' => 'required|max:255',
            'avg_rating' => 'nullable|numeric|between:0,5',
        ], $messages);

        if ($validator->fails()) {
            return redirect('courses/adding')->withErrors($validator)->withInput();
        }

        try {
            $coverPath = null;
            if ($request->hasFile('cover_img')) {
                $coverPath = $request->file('cover_img')->store('uploads/courses', 'public');
            }

            CoursesModel::create([
                'title' => strip_tags($request->title),
                'category_id' => $request->category_id,
                'provider' => strip_tags($request->provider),
                'provider_instructor' => strip_tags($request->provider_instructor),
                'level' => $request->level ?? 'beginner',
                'language' => $request->language ?? 'TH',
                'price_type' => $request->price_type,
                'price' => $request->price ?? 0,
                'duration_text' => $request->duration_text,
                'description' => $request->description,
                'cover_img' => $coverPath,
                'course_url' => $request->course_url,
                'avg_rating' => $request->avg_rating ?? 0,
                'created_at' => now(),
            ]);

            Alert::success('Insert Successfully');
            return redirect('/courses');
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // ================= EDIT =================
    public function edit($id)
    {
        try {
            $course = CoursesModel::findOrFail($id); // ต้องตั้ง $primaryKey ที่ Model ถ้าใช้ course_id

            // ส่งทั้ง $id และฟิลด์ที่ view ใช้
            $id = $course->getKey(); // ค่าของ primary key ปัจจุบัน
            $course_id = $course->course_id; // ถ้าต้องการใช้ใน view

            $title = $course->title;
            $category_id = $course->category_id;
            $provider = $course->provider;
            $provider_instructor = $course->provider_instructor;
            $level = $course->level;
            $language = $course->language;
            $price_type = $course->price_type;
            $price = $course->price;
            $duration_text = $course->duration_text;
            $description = $course->description;
            $cover_img = $course->cover_img;
            $course_url = $course->course_url;
            $avg_rating = $course->avg_rating;

            return view('courses.edit', compact(
                'course',
                'id',            // << เพิ่มให้แน่ใจว่า view ใช้ตัวนี้ได้
                'course_id',
                'title',
                'category_id',
                'provider',
                'provider_instructor',
                'level',
                'language',
                'price_type',
                'price',
                'duration_text',
                'description',
                'cover_img',
                'course_url',
                'avg_rating'
            ));
        } catch (\Exception $e) {
            return view('errors.404');
        }
    }

    // ================= UPDATE =================
    public function update($id, Request $request)
    {
        $messages = [
            'title.required' => 'กรุณากรอกชื่อคอร์ส',
            'provider.required' => 'กรุณากรอกผู้ให้บริการ',
            'price_type.required' => 'กรุณาเลือกประเภทการใช้งาน',
            'price.numeric' => 'กรุณากรอกราคาเป็นตัวเลข',
            'cover_img.mimes' => 'รองรับ jpeg, png, jpg เท่านั้น',
            'cover_img.max' => 'ขนาดไฟล์ไม่เกิน 5MB',
        ];

        $validator = Validator::make($request->all(), [
            'title' => 'required|min:3|max:200',
            'category_id' => 'required|integer',
            'provider' => 'required|max:120',
            'provider_instructor' => 'nullable|max:120',
            'level' => 'nullable|max:20',
            'language' => 'nullable|max:50',
            'price_type' => 'required|max:10',
            'price' => 'nullable|numeric|min:0',
            'duration_text' => 'nullable|max:60',
            'description' => 'nullable',
            'cover_img' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'course_url' => 'required|max:255',
            'avg_rating' => 'nullable|numeric|between:0,5',
        ], $messages);

        if ($validator->fails()) {
            return redirect('courses/' . $id)->withErrors($validator)->withInput();
        }

        try {
            $course = CoursesModel::findOrFail($id);

            // อัปเดตรูป (ถ้ามีอัปโหลดใหม่)
            if ($request->hasFile('cover_img')) {
                if (!empty($course->cover_img) && Storage::disk('public')->exists($course->cover_img)) {
                    Storage::disk('public')->delete($course->cover_img);
                }
                $coverPath = $request->file('cover_img')->store('uploads/courses', 'public');
                $course->cover_img = $coverPath;
            }

            // อัปเดตทุกฟิลด์ที่ต้องการ
            $course->title = strip_tags($request->title);
            $course->category_id = $request->category_id;
            $course->provider = strip_tags($request->provider);
            $course->provider_instructor = strip_tags($request->provider_instructor);
            $course->level = $request->level ?? 'beginner';
            $course->language = $request->language ?? 'TH';
            $course->price_type = $request->price_type;
            $course->price = $request->price ?? 0;
            $course->duration_text = $request->duration_text;
            $course->description = $request->description;
            $course->course_url = $request->course_url;
            $course->avg_rating = $request->avg_rating ?? 0;

            $course->save();

            Alert::success('Update Successfully');
            return redirect('/courses');
        } catch (\Exception $e) {
            return view('errors.404');
        }
    }

    // ================= DELETE =================
    public function remove($id)
    {
        try {
            $course = CoursesModel::find($id);

            if (!$course) {
                Alert::error('Course not found.');
                return redirect('courses');
            }

            if (!empty($course->cover_img) && Storage::disk('public')->exists($course->cover_img)) {
                Storage::disk('public')->delete($course->cover_img);
            }

            $course->delete();
            Alert::success('Delete Successfully');
            return redirect('courses');
        } catch (\Exception $e) {
            Alert::error('เกิดข้อผิดพลาด: ' . $e->getMessage());
            return redirect('courses');
        }
    }
}
