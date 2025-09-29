<?php

namespace App\Http\Controllers;

use App\Models\CoursesModel;
use App\Models\CategoryModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Pagination\Paginator;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CoursesController extends Controller
{

    /* =========================================================
     * Utilities
     * =======================================================*/

    // ปรับคะแนนให้อยู่ช่วง 0..5 และปัดครึ่งดาว
    private function normalizeRating($v): float
    {
        $n = is_numeric($v) ? (float) $v : 0.0;
        $n = max(0, min(5, $n));
        return round($n * 2) / 2; // step 0.5
    }

    // ราคา: free => 0, paid => ปัดทศนิยม 2 ตำแหน่ง และคุมเพดาน DECIMAL(10,2)
    private function normalizePrice(?string $type, $price): float
    {
        if (($type ?? 'free') === 'free') {
            return 0.0;
        }
        $n = is_numeric($price) ? (float) $price : 0.0;
        $n = min($n, 99999999.99);
        return round($n, 2);
    }

    // เก็บรูปหน้าปก (คืน path ใน disk 'public') หรือคืนค่าเดิมถ้าไม่อัปโหลดใหม่
    private function storeCoverIfAny(Request $request, ?string $old = null): string
    {
        if ($request->hasFile('cover_img')) {
            try {
                if ($old && Storage::disk('public')->exists($old)) {
                    Storage::disk('public')->delete($old);
                }
            } catch (\Throwable $e) { /* ignore */
            }

            return $request->file('cover_img')->store('uploads/courses', 'public');
        }
        return $old ?? '';
    }

    // ช่วยจัดการ sort key ให้ปลอดภัย
    private function applySort($query, string $sort)
    {
        switch ($sort) {
            case 'id_asc':
                return $query->orderBy('course_id', 'asc');
            case 'id_desc':
                return $query->orderBy('course_id', 'desc');
            case 'price_asc':
                return $query->orderBy('price', 'asc');
            case 'price_desc':
                return $query->orderBy('price', 'desc');
            default:
                return $query->orderBy('course_id', 'asc');
        }
    }

    // ===== เพิ่มใหม่: คำนวณค่าเฉลี่ยจาก tbl_reviews แล้วอัปเดตลง tbl_courses.avg_rating =====
    private function recalcAvgRating(int $courseId): void
    {
        $avg = DB::table('tbl_reviews')
            ->where('course_id', $courseId)
            ->avg('rating');

        $avg = $avg === null ? 0 : round(((float) $avg) * 2) / 2; // ปัดครึ่งดาว .0/.5

        DB::table('tbl_courses')
            ->where('course_id', $courseId)
            ->update(['avg_rating' => $avg]);
    }

    /* =========================================================
     * FRONTEND (ตัวอย่างเดิม)
     * =======================================================*/
    public function frontend(Request $request)
    {
        try {
            $q         = trim((string) $request->query('q', ''));
            $level     = $request->query('level');
            $language  = $request->query('language');
            $priceType = $request->query('price_type');
            $provider  = $request->query('provider');
            $sort      = $request->query('sort', 'latest');

            $query = CoursesModel::query();

            if ($q !== '') {
                $query->where(function ($w) use ($q) {
                    $w->where('title', 'like', "%{$q}%")
                        ->orWhere('description', 'like', "%{$q}%")
                        ->orWhere('provider', 'like', "%{$q}%");
                });
            }

            if (!empty($level))     $query->where('level', $level);
            if (!empty($language))  $query->where('language', $language);
            if (!empty($priceType)) $query->where('price_type', $priceType);
            if (!empty($provider))  $query->where('provider', $provider);

            switch ($sort) {
                case 'price_asc':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price_desc':
                    $query->orderBy('price', 'desc');
                    break;
                case 'rating_desc':
                    $query->orderBy('avg_rating', 'desc');
                    break;
                default:
                    $query->orderBy('course_id', 'desc');
            }

            $courses = $query->paginate(12)->withQueryString();
            return view('layouts.frontend', compact('courses'));
        } catch (\Throwable $e) {
            return view('errors.404');
        }
    }

    /* =========================================================
     * LIST (หลังบ้าน) — ใช้กับ list.blade
     * =======================================================*/
    public function index(Request $request)
    {
        try {
            // ให้ Bootstrap theme กับ pagination
            Paginator::useBootstrap();

            // รองรับ sort จาก query string (ค่าเริ่มต้น id_asc)
            $sort = (string) $request->query('sort', 'id_asc');

            // โหลดข้อมูลคอร์ส
            $qb = CoursesModel::query();

            // จัดเรียงตามคีย์ที่ปลอดภัย
            $this->applySort($qb, $sort);

            // แสดง 5 รายการต่อหน้า
            $perPage = 5;
            $courses = $qb->paginate($perPage)->withQueryString();

            // เพิ่มฟิลด์ช่วยสำหรับ view
            $courses->getCollection()->transform(function ($row) {
                $row->created_for_view = optional($row->created_at)->format('Y-m-d H:i');
                $row->updated_for_view = optional($row->updated_at)->format('Y-m-d H:i');

                // เพิ่มชื่อ category ถ้าไม่มี relation
                if (!isset($row->category) && isset($row->category_id)) {
                    try {
                        $category = \App\Models\CategoryModel::find($row->category_id);
                        $row->category_name = $category ? $category->name : "หมวด #{$row->category_id}";
                    } catch (\Exception $e) {
                        $row->category_name = "หมวด #{$row->category_id}";
                    }
                }

                return $row;
            });

            // หากผู้ใช้พิมพ์เลขหน้าที่เกิน ทำให้หน้าเปล่า → เด้งไปหน้าสุดท้าย
            if ($courses->isEmpty() && $request->has('page') && (int) $request->get('page') > 1) {
                return redirect()->fullUrlWithQuery(['page' => $courses->lastPage()]);
            }

            return view('courses.list', compact('courses'));

        } catch (\Exception $e) {
            \Log::error('CoursesController@index ERROR: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
                'request' => $request->all()
            ]);

            Alert::error('เกิดข้อผิดพลาด', 'ไม่สามารถโหลดรายการคอร์สได้ กรุณาลองใหม่อีกครั้ง');
            return redirect()->route('frontend')->withErrors(['error' => 'ไม่สามารถโหลดหน้านี้ได้']);
        }
    }

    /* =========================================================
     * FORM: CREATE (ส่ง dropdown หมวดหมู่ไปหน้าเพิ่มคอร์ส)
     * =======================================================*/
    public function adding()
    {
        try {
            $categories = CategoryModel::orderBy('category_id', 'asc')->get(['category_id', 'name']);
        } catch (\Exception $e) {
            // ถ้าไม่สามารถโหลด categories ได้ ให้ใช้ array ว่าง
            \Log::warning('Cannot load categories in adding(): ' . $e->getMessage());
            $categories = collect([]);
        }

        return view('courses.create', compact('categories'));
    }

    /* =========================================================
     * STORE (POST /courses) — รองรับ dropdown + validate exists
     * =======================================================*/
    public function create(Request $request)
    {
        $messages = [
            'title.required'              => 'กรุณากรอกชื่อคอร์ส',
            'title.max'                   => 'ชื่อคอร์สไม่เกิน :max ตัวอักษร',
            'category_id.required'        => 'กรุณาเลือกหมวดหมู่',
            'category_id.integer'         => 'หมวดหมู่ต้องเป็นตัวเลข',
            'category_id.between'         => 'หมวดหมู่ต้องอยู่ระหว่าง :min ถึง :max',
            'category_id.exists'          => 'หมวดหมู่ที่เลือกไม่มีอยู่ในระบบ',
            'provider.required'           => 'กรุณากรอกผู้ให้บริการ',
            'provider.max'                => 'ผู้ให้บริการไม่เกิน :max ตัวอักษร',
            'provider_instructor.max'     => 'ชื่อผู้สอนไม่เกิน :max ตัวอักษร',
            'level.required'              => 'กรุณาเลือกระดับเนื้อหา',
            'level.in'                    => 'ระดับเนื้อหาไม่ถูกต้อง',
            'language.required'           => 'กรุณาเลือกภาษา',
            'language.in'                 => 'ภาษาไม่ถูกต้อง',
            'price_type.required'         => 'กรุณาเลือกรูปแบบราคา',
            'price.required_if'           => 'กรุณากรอกราคาสำหรับคอร์สแบบชำระเงิน',
            'price.numeric'               => 'ราคาเป็นตัวเลขเท่านั้น',
            'price.min'                   => 'ราคาอย่างน้อย :min บาท',
            'price.max'                   => 'ราคาไม่เกิน :max บาท',
            'duration_text.max'           => 'ระยะเวลาเรียนไม่เกิน :max ตัวอักษร',
            'course_url.required'         => 'กรุณากรอกลิงก์หน้าคอร์ส',
            'course_url.url'              => 'รูปแบบลิงก์ไม่ถูกต้อง',
            'avg_rating.numeric'          => 'คะแนนต้องเป็นตัวเลข',
            'avg_rating.between'          => 'คะแนนต้องอยู่ระหว่าง 0 ถึง 5',
            'cover_img.required'          => 'กรุณาเลือกรูปหน้าปกคอร์ส',
            'cover_img.image'             => 'ไฟล์ต้องเป็นรูปภาพ',
            'cover_img.mimes'             => 'รองรับเฉพาะไฟล์: :values',
            'cover_img.max'               => 'ขนาดไฟล์ต้องไม่เกิน :max กิโลไบต์',
        ];

        $rules = [
            'title'               => 'required|string|max:200',
            'category_id'         => 'required|integer|between:1,999999|exists:tbl_categories,category_id',
            'provider'            => 'required|string|max:120',
            'provider_instructor' => 'nullable|string|max:120',
            'level'               => 'required|in:beginner,intermediate,advanced',
            'language'            => 'required|in:TH,EN',
            'price_type'          => 'required|in:free,paid',
            'price'               => 'exclude_if:price_type,free|required_if:price_type,paid|numeric|min:0|max:99999999.99',
            'duration_text'       => 'nullable|string|max:600',
            'description'         => 'nullable|string',
            'cover_img'           => 'required|image|mimes:jpg,jpeg,png|max:5120',
            'course_url'          => 'required|url|max:255',
            'avg_rating'          => 'nullable|numeric|between:0,5',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        // ตรวจทศนิยม 2 ตำแหน่งสำหรับ price
        $validator->after(function ($v) use ($request) {
            if (($request->price_type ?? 'free') === 'paid' && $request->filled('price')) {
                $price = (string) $request->price;
                if (preg_match('/^\d+(\.\d{1,2})?$/', $price) !== 1) {
                    $v->errors()->add('price', 'ราคาใส่ทศนิยมได้ไม่เกิน 2 ตำแหน่ง');
                }
            }
        });

        if ($validator->fails()) {
            return redirect()->route('admin.courses.adding')->withErrors($validator)->withInput();
        }

        try {
            $data = $validator->validated();

            // normalize
            $data['price_type']    = in_array($data['price_type'], ['free', 'paid']) ? $data['price_type'] : 'free';
            $data['price']         = $this->normalizePrice($data['price_type'], $request->input('price'));
            $data['avg_rating']    = $this->normalizeRating($data['avg_rating'] ?? 0);
            $data['description']   = $data['description'] ?? '';
            $data['duration_text'] = $data['duration_text'] ?? '';

            // รูปปก
            $data['cover_img'] = $this->storeCoverIfAny($request, '');

            CoursesModel::create([
                'title'               => strip_tags($data['title']),
                'category_id'         => (int) $data['category_id'],
                'provider'            => strip_tags($data['provider']),
                'provider_instructor' => $data['provider_instructor'] ? strip_tags($data['provider_instructor']) : null,
                'level'               => $data['level'],
                'language'            => $data['language'],
                'price_type'          => $data['price_type'],
                'price'               => $data['price'],
                'duration_text'       => $data['duration_text'],
                'description'         => $data['description'],
                'cover_img'           => $data['cover_img'],
                'course_url'          => $data['course_url'],
                'avg_rating'          => $data['avg_rating'],
                'created_at'          => now(), // ให้แน่ใจว่ามี "สร้างเมื่อ"
            ]);

            Alert::success('สำเร็จ', 'เพิ่มคอร์สเรียบร้อยแล้ว');
            return redirect()->route('admin.courses.index');
        } catch (\Throwable $e) {
            Alert::error('เกิดข้อผิดพลาด', $e->getMessage());
            return back()->withInput();
        }
    }

    /* =========================================================
     * FORM: CREATE (ส่ง dropdown หมวดหมู่ไปหน้าแก้ไขคอร์ส)
     * =======================================================*/
    public function edit($id)
    {
        try {
            $course = CoursesModel::findOrFail($id);

            // ส่ง dropdown categories ด้วย error handling
            try {
                $categories = CategoryModel::orderBy('category_id', 'asc')->get(['category_id', 'name']);
            } catch (\Exception $e) {
                \Log::warning('Cannot load categories in edit(): ' . $e->getMessage());
                $categories = collect([]);
            }

            // ส่งตัวแปรที่ view ใช้เดิม
            $id                  = $course->getKey();
            $course_id           = $course->course_id;
            $title               = $course->title;
            $category_id         = $course->category_id;
            $provider            = $course->provider;
            $provider_instructor = $course->provider_instructor;
            $level               = $course->level;
            $language            = $course->language;
            $price_type          = $course->price_type;
            $price               = $course->price;
            $duration_text       = $course->duration_text;
            $description         = $course->description;
            $cover_img           = $course->cover_img;
            $course_url          = $course->course_url;
            $avg_rating          = $course->avg_rating;

            return view('courses.edit', compact(
                'course',
                'categories',
                'id',
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
        } catch (\Throwable $e) {
            return view('errors.404');
        }
    }

    /* =========================================================
     * UPDATE (PUT /courses/{id}) — รองรับ dropdown + validate exists
     * =======================================================*/
    public function update($id, Request $request)
    {
        $messages = [
            'title.required'              => 'กรุณากรอกชื่อคอร์ส',
            'title.max'                   => 'ชื่อคอร์สไม่เกิน :max ตัวอักษร',
            'category_id.required'        => 'กรุณาเลือกหมวดหมู่',
            'category_id.integer'         => 'หมวดหมู่ต้องเป็นตัวเลข',
            'category_id.between'         => 'หมวดหมู่ต้องอยู่ระหว่าง :min ถึง :max',
            'category_id.exists'          => 'หมวดหมู่ที่เลือกไม่มีอยู่ในระบบ',
            'provider.required'           => 'กรุณากรอกผู้ให้บริการ',
            'provider.max'                => 'ผู้ให้บริการไม่เกิน :max ตัวอักษร',
            'provider_instructor.max'     => 'ชื่อผู้สอนไม่เกิน :max ตัวอักษร',
            'level.required'              => 'กรุณาเลือกระดับเนื้อหา',
            'level.in'                    => 'ระดับเนื้อหาไม่ถูกต้อง',
            'language.required'           => 'กรุณาเลือกภาษา',
            'language.in'                 => 'ภาษาไม่ถูกต้อง',
            'price_type.required'         => 'กรุณาเลือกรูปแบบราคา',
            'price.required_if'           => 'กรุณากรอกราคาสำหรับคอร์สแบบชำระเงิน',
            'price.numeric'               => 'ราคาเป็นตัวเลขเท่านั้น',
            'price.min'                   => 'ราคาอย่างน้อย :min บาท',
            'price.max'                   => 'ราคาไม่เกิน :max บาท',
            'duration_text.max'           => 'ระยะเวลาเรียนไม่เกิน :max ตัวอักษร',
            'course_url.required'         => 'กรุณากรอกลิงก์หน้าคอร์ส',
            'course_url.url'              => 'รูปแบบลิงก์ไม่ถูกต้อง',
            'avg_rating.numeric'          => 'คะแนนต้องเป็นตัวเลข',
            'avg_rating.between'          => 'คะแนนต้องอยู่ระหว่าง 0 ถึง 5',
            'cover_img.image'             => 'ไฟล์ต้องเป็นรูปภาพ',
            'cover_img.mimes'             => 'รองรับเฉพาะไฟล์: :values',
            'cover_img.max'               => 'ขนาดไฟล์ต้องไม่เกิน :max กิโลไบต์',
        ];

        $rules = [
            'title'               => 'required|string|max:200',
            'category_id'         => 'required|integer|between:1,999999|exists:tbl_categories,category_id',
            'provider'            => 'required|string|max:120',
            'provider_instructor' => 'nullable|string|max:120',
            'level'               => 'required|in:beginner,intermediate,advanced',
            'language'            => 'required|in:TH,EN',
            'price_type'          => 'required|in:free,paid',
            'price'               => 'exclude_if:price_type,free|required_if:price_type,paid|numeric|min:0|max:99999999.99',
            'duration_text'       => 'nullable|string|max:600',
            'description'         => 'nullable|string',
            'cover_img'           => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
            'course_url'          => 'required|url|max:255',
            'avg_rating'          => 'nullable|numeric|between:0,5',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        $validator->after(function ($v) use ($request) {
            if (($request->price_type ?? 'free') === 'paid' && $request->filled('price')) {
                $price = (string) $request->price;
                if (preg_match('/^\d+(\.\d{1,2})?$/', $price) !== 1) {
                    $v->errors()->add('price', 'ราคาใส่ทศนิยมได้ไม่เกิน 2 ตำแหน่ง');
                }
            }
        });

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $course = CoursesModel::findOrFail($id);
            $data   = $validator->validated();

            // normalize
            $data['price_type']    = in_array($data['price_type'], ['free', 'paid']) ? $data['price_type'] : 'free';
            $data['price']         = $this->normalizePrice($data['price_type'], $request->input('price', $course->price));
            $data['avg_rating']    = $this->normalizeRating($data['avg_rating'] ?? $course->avg_rating);
            $data['description']   = $data['description'] ?? '';
            $data['duration_text'] = $data['duration_text'] ?? '';

            // อัปโหลดรูปใหม่ (ถ้ามี)
            $data['cover_img'] = $this->storeCoverIfAny($request, $course->cover_img ?: '');

            // update
            $course->update([
                'title'               => strip_tags($data['title']),
                'category_id'         => (int) $data['category_id'],
                'provider'            => strip_tags($data['provider']),
                'provider_instructor' => $data['provider_instructor'] ? strip_tags($data['provider_instructor']) : null,
                'level'               => $data['level'],
                'language'            => $data['language'],
                'price_type'          => $data['price_type'],
                'price'               => $data['price'],
                'duration_text'       => $data['duration_text'],
                'description'         => $data['description'],
                'cover_img'           => $data['cover_img'],
                'course_url'          => $data['course_url'],
                'avg_rating'          => $data['avg_rating'],
            ]);

            Alert::success('สำเร็จ', 'บันทึกการเปลี่ยนแปลงเรียบร้อยแล้ว');
            return redirect()->route('admin.courses.index');
        } catch (\Throwable $e) {
            Alert::error('เกิดข้อผิดพลาด', $e->getMessage());
            return back()->withInput();
        }
    }

    /* =========================================================
     * DELETE
     * =======================================================*/
    public function remove($id)
    {
        try {
            $course = CoursesModel::find($id);

            if (!$course) {
                Alert::error('ไม่พบข้อมูลคอร์ส');
                return redirect()->route('admin.courses.index');
            }

            try {
                if (!empty($course->cover_img) && Storage::disk('public')->exists($course->cover_img)) {
                    Storage::disk('public')->delete($course->cover_img);
                }
            } catch (\Throwable $e) { /* ignore */
            }

            $course->delete();
            Alert::success('สำเร็จ', 'ลบคอร์สเรียบร้อยแล้ว');
            return redirect()->route('admin.courses.index');
        } catch (\Throwable $e) {
            Alert::error('เกิดข้อผิดพลาด', $e->getMessage());
            return redirect()->route('admin.courses.index');
        }
    }

    /* =========================================================
    * SHOW (ดูรายละเอียดคอร์ส)
    * =======================================================*/
    public function show($id)
    {
        $course = CoursesModel::findOrFail($id);

        // ชื่อหมวดหมู่ (ถ้ามีตาราง tbl_categories)
        $categoryName = DB::table('tbl_categories')
            ->where('category_id', $course->category_id)
            ->value('name');

        // รูป
        $imageUrl = '';
        if (!empty($course->cover_img) && \Storage::disk('public')->exists($course->cover_img)) {
            $imageUrl = \Storage::url($course->cover_img);
        } else {
            $imageUrl = file_exists(public_path('images/placeholder.png'))
                ? asset('images/placeholder.png')
                : 'https://via.placeholder.com/1200x630?text=No+Image';
        }

        // สถานะ favorite ของผู้ใช้ปัจจุบัน
        $isFavorited = false;
        if (Auth::check()) {
            $isFavorited = DB::table('tbl_favorites')
                ->where('user_id', Auth::id())
                ->where('course_id', $course->course_id)
                ->exists();
        }

        // ดึงรีวิว (paginate)
        $reviews = DB::table('tbl_reviews')
            ->select('review_id', 'course_id', 'user_id', 'rating', 'comment', 'created_at')
            ->where('course_id', $course->course_id)
            ->orderByDesc('review_id')
            ->paginate(5);

        return view('courses.courses_details', compact(
            'course',
            'categoryName',
            'imageUrl',
            'isFavorited',
            'reviews'
        ));
    }

    /** TOGGLE FAVORITE: เพิ่ม/ลบ รายการโปรด */
    public function toggleFavorite(Request $request, $courseId)
    {
        $userId = \Illuminate\Support\Facades\Auth::guard('member')->id();
        abort_if(!$userId, 401, 'Unauthorized');

        // ชี้คอลัมน์ให้ตรงฐานข้อมูล
        $courseExists = DB::table('tbl_courses')->where('course_id', $courseId)->exists();
        abort_if(!$courseExists, 404);

        $exists = DB::table('tbl_favorites')->where('user_id', $userId)->where('course_id', $courseId)->exists();

        if ($exists) {
            DB::table('tbl_favorites')->where('user_id', $userId)->where('course_id', $courseId)->delete();
        } else {
            DB::table('tbl_favorites')->insert(['user_id' => $userId, 'course_id' => $courseId, 'created_at' => now()]);
        }

        // ถ้าขอ JSON (จาก fetch) → ส่ง 204 กลับไป เพื่อไม่ต้อง redirect
        if ($request->expectsJson()) {
            return response()->noContent(); // 204
        }
        return back();
    }

    /** STORE REVIEW: บันทึกรีวิว + อัปเดตค่าเฉลี่ยลง courses */
    public function storeReview(Request $request, $courseId)
    {
        $userId = \Illuminate\Support\Facades\Auth::guard('member')->id();
        abort_if(!$userId, 401, 'Unauthorized');

        $data = $request->validate([
            'rating'  => ['required', 'numeric', 'between:1,5'],
            'comment' => ['required', 'string', 'max:2000'],
        ], [
            'rating.required'  => 'กรุณาให้คะแนน',
            'rating.between'   => 'คะแนนต้องอยู่ระหว่าง 1 ถึง 5',
            'comment.required' => 'กรุณาเขียนรีวิว',
        ]);

        // มีรีวิวแล้ว → ไม่อนุญาตให้รีวิว/แก้ซ้ำ
        $exists = DB::table('tbl_reviews')
            ->where('user_id', $userId)
            ->where('course_id', $courseId)
            ->exists();

        if ($exists) {
            return back()->withErrors([
                // ผูกที่ 'comment' เพื่อให้ข้อความไปขึ้นใต้กล่องข้อความตาม Blade ปัจจุบัน
                'comment' => 'คุณได้รีวิวคอร์สนี้แล้ว ไม่สามารถรีวิวซ้ำหรือแก้ไขได้',
            ])->withInput();
        }

        try {
            DB::table('tbl_reviews')->insert([
                'user_id'    => $userId,
                'course_id'  => $courseId,
                'rating'     => (int) round($data['rating']),
                'comment'    => trim($data['comment']),
                'created_at' => now(),   // ตารางคุณไม่มี updated_at
            ]);
        } catch (\Illuminate\Database\QueryException $e) {
            // กัน race condition: ถ้าชน unique key
            if ($e->getCode() === '23000') {
                return back()->withErrors([
                    'comment' => 'คุณได้รีวิวคอร์สนี้แล้ว ไม่สามารถรีวิวซ้ำหรือแก้ไขได้',
                ])->withInput();
            }
            throw $e;
        }

        // ===== เพิ่มใหม่: อัปเดตค่าเฉลี่ยของคอร์สทันทีหลังบันทึกรีวิว =====
        $this->recalcAvgRating((int) $courseId);

        return back()->with('status', 'review_saved');
    }

    /* =========================================================
     * FAVORITES PAGE (ใหม่) — แสดงรายการโปรดของผู้ใช้
     * =======================================================*/
    public function favorites(Request $request)
    {
        $userId = Auth::id();
        if (!$userId) {
            $userId = Auth::guard('member')->id();
        }
        if (!$userId) {
            return redirect()->route('login');
        }

        $q    = (string) $request->query('q', '');
        $sort = (string) $request->query('sort', 'new'); // new|rating|title

        $query = DB::table('tbl_favorites')
            ->join('tbl_courses', 'tbl_courses.course_id', '=', 'tbl_favorites.course_id')
            ->where('tbl_favorites.user_id', $userId)
            ->select(
                'tbl_courses.*',
                'tbl_favorites.created_at as favored_at',
                'tbl_courses.course_id as id' // ★ เพิ่ม alias ให้ Blade ใช้ $c->id ได้
            );

        if ($q !== '') {
            $query->where('tbl_courses.title', 'like', "%{$q}%");
        }

        if ($sort === 'rating') {
            $query->orderByDesc('tbl_courses.avg_rating');
        } elseif ($sort === 'title') {
            $query->orderBy('tbl_courses.title');
        } else {
            $query->orderByDesc('favored_at');
        }

        $courses = $query->paginate(12)->withQueryString();

        return view('courses.favorites', compact('courses', 'q', 'sort'));
    }
}
