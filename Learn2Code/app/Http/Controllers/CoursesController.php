<?php

namespace App\Http\Controllers;

use App\Models\CoursesModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Pagination\Paginator;
use RealRashid\SweetAlert\Facades\Alert;

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
        // ให้ Bootstrap theme กับ pagination
        Paginator::useBootstrap();

        // รองรับ sort จาก query string (ค่าเริ่มต้น id_asc)
        $sort = (string) $request->query('sort', 'id_asc');

        // ถ้าต้องการค้นหา/ฟิลเตอร์ในอนาคตสามารถเพิ่มเงื่อนไขได้ที่นี่
        $qb = CoursesModel::query();

        // จัดเรียงตามคีย์ที่ปลอดภัย
        $this->applySort($qb, $sort);

        // *** กำหนดให้แสดง 5 รายการต่อหน้าเสมอสำหรับหน้า List ***
        $perPage = 5;

        $courses = $qb->paginate($perPage)->withQueryString();

        // เพิ่มฟิลด์ช่วยสำหรับ view: created_for_view / updated_for_view (ไม่บังคับใช้ใน blade ก็ได้)
        // ทำให้แน่ใจว่ามีสตริง "สร้างเมื่อ" พร้อมใช้เสมอ
        $courses->getCollection()->transform(function ($row) {
            $row->created_for_view = optional($row->created_at)->format('Y-m-d H:i');
            $row->updated_for_view = optional($row->updated_at)->format('Y-m-d H:i');
            return $row;
        });

        // หากผู้ใช้พิมพ์เลขหน้าที่เกิน ทำให้หน้าเปล่า → เด้งไปหน้าสุดท้าย
        if ($courses->isEmpty() && $request->has('page') && (int) $request->get('page') > 1) {
            return redirect()->fullUrlWithQuery(['page' => $courses->lastPage()]);
        }

        // ส่ง $courses ไปที่ view list.blade
        // ภายใน $courses มีฟิลด์ที่โมดัล/ตารางต้องใช้ครบ เช่น:
        // - $row->course_url (ลิงก์ไปหน้าคอร์ส)
        // - $row->created_at (ใช้แสดง “สร้างเมื่อ” ใน list.blade)
        // - $row->duration_text, $row->provider_instructor ฯลฯ
        return view('courses.list', compact('courses'));
    }

    /* =========================================================
     * FORM: CREATE
     * =======================================================*/
    public function adding()
    {
        return view('courses.create');
    }

    /* =========================================================
     * STORE (POST /courses)
     * =======================================================*/
    public function create(Request $request)
    {
        $messages = [
            'title.required'              => 'กรุณากรอกชื่อคอร์ส',
            'title.max'                   => 'ชื่อคอร์สไม่เกิน :max ตัวอักษร',
            'category_id.required'        => 'กรุณากรอกหมวดหมู่ (ID)',
            'category_id.integer'         => 'หมวดหมู่ต้องเป็นตัวเลข',
            'category_id.between'         => 'หมวดหมู่ต้องอยู่ระหว่าง :min ถึง :max',
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
            'category_id'         => 'required|integer|between:0,999999',
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
            return redirect('courses/adding')->withErrors($validator)->withInput();
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
            return redirect('/courses');
        } catch (\Throwable $e) {
            Alert::error('เกิดข้อผิดพลาด', $e->getMessage());
            return back()->withInput();
        }
    }

    /* =========================================================
     * EDIT FORM
     * =======================================================*/
    public function edit($id)
    {
        try {
            $course = CoursesModel::findOrFail($id);

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
     * UPDATE (PUT /courses/{id})
     * =======================================================*/
    public function update($id, Request $request)
    {
        $messages = [
            'title.required'              => 'กรุณากรอกชื่อคอร์ส',
            'title.max'                   => 'ชื่อคอร์สไม่เกิน :max ตัวอักษร',
            'category_id.required'        => 'กรุณากรอกหมวดหมู่ (ID)',
            'category_id.integer'         => 'หมวดหมู่ต้องเป็นตัวเลข',
            'category_id.between'         => 'หมวดหมู่ต้องอยู่ระหว่าง :min ถึง :max',
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
            'category_id'         => 'required|integer|between:0,999999',
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
            return redirect('/courses');
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
                return redirect('courses');
            }

            try {
                if (!empty($course->cover_img) && Storage::disk('public')->exists($course->cover_img)) {
                    Storage::disk('public')->delete($course->cover_img);
                }
            } catch (\Throwable $e) { /* ignore */
            }

            $course->delete();
            Alert::success('สำเร็จ', 'ลบคอร์สเรียบร้อยแล้ว');
            return redirect('courses');
        } catch (\Throwable $e) {
            Alert::error('เกิดข้อผิดพลาด', $e->getMessage());
            return redirect('courses');
        }
    }
}