<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request; //รับค่าจากฟอร์ม
use Illuminate\Support\Facades\Validator; //form validation
use RealRashid\SweetAlert\Facades\Alert; //sweet alert
use Illuminate\Support\Facades\Storage; //สำหรับเก็บไฟล์ภาพ
use Illuminate\Pagination\Paginator; //แบ่งหน้า
use App\Models\StudentModel; //model
use Illuminate\Validation\Rule;



class StudentController extends Controller
{

    public function index(){
        Paginator::useBootstrap(); // ใช้ Bootstrap pagination
        $student = StudentModel::orderBy('id', 'desc')->paginate(5); //order by & pagination
         //return response()->json(['error' => $e->getMessage()], 500); //สำหรับ debug
        return view('students.list', compact('student+'));
    }

    public function adding() {
        return view('students.create');
    }


public function create(Request $request)
{
    //msg
    $messages = [
        'std_code.required' => 'กรุณากรอกข้อมูล',
        'std_code.min' => 'ต้องมีอย่างน้อย :min ตัวอักษร',
        'std_code.unique' => 'ข้อมูลซ้ำ',
        'std_name.required' => 'กรุณากรอกข้อมูล',
        'std_name.min' => 'ต้องมีอย่างน้อย :min ตัวอักษร',
        'std_phone.required' => 'กรุณากรอกข้อมูล',
        'std_phone.min' => 'ต้องมีอย่างน้อย :min ตัวอักษร',
        'std_phone.max' => 'ห้ามเกิน :max ตัวอักษร',
        'std_img.mimes' => 'รองรับ jpeg, png, jpg เท่านั้น !!',
        'std_img.max' => 'ขนาดไฟล์ไม่เกิน 5MB !!',
    ];

    //rule ตั้งขึ้นว่าจะเช็คอะไรบ้าง
    $validator = Validator::make($request->all(), [
        'std_code' => 'required|min:3|unique:tbl_student',
        'std_name' => 'required|min:5',
        'std_phone' => 'required|min:10|max:10',
        'std_img' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
    ], $messages);
    

    //ถ้าผิดกฏให้อยู่หน้าเดิม และแสดง msg ออกมา
    if ($validator->fails()) {
        return redirect('student/adding')
            ->withErrors($validator)
            ->withInput();
    }


    //ถ้ามีการอัพโหลดไฟล์เข้ามา ให้อัพโหลดไปเก็บยังโฟลเดอร์ uploads/product
    try {
        $imagePath = null;
        if ($request->hasFile('std_img')) {
            $imagePath = $request->file('std_img')->store('uploads/student', 'public');
        }

        //insert เพิ่มข้อมูลลงตาราง
        StudentModel::create([
            'std_code' => strip_tags($request->std_code),
            'std_name' => strip_tags($request->std_name),
            'std_phone' => strip_tags($request->std_phone),
            'std_img' => $imagePath,
        ]);

        //แสดง sweet alert
        Alert::success('Insert Successfully');
        return redirect('/student');

    } catch (\Exception $e) {  //error debug
        return response()->json(['error' => $e->getMessage()], 500); //สำหรับ debug
        //return view('errors.404');
    }
} //create 

public function edit($id)
    {
        try {
            $product = StudentModel::findOrFail($id); // ใช้ findOrFail เพื่อให้เจอหรือ 404

            //ประกาศตัวแปรเพื่อส่งไปที่ view
            if (isset($product)) {
                $id = $product->id;
                $product_name = $product->product_name;
                $product_detail = $product->product_detail;
                $product_price = $product->product_price;
                $product_img = $product->product_img;
                return view('students.edit', compact('id', 'product_name', 'product_detail', 'product_price', 'product_img'));
            }
        } catch (\Exception $e) {
            //return response()->json(['error' => $e->getMessage()], 500); //สำหรับ debug
            return view('errors.404');
        }
    } //func edit

public function update($id, Request $request)
{
    //error msg
     $messages = [
        'std_code.required' => 'กรุณากรอกข้อมูล',
        'std_code.min' => 'ต้องมีอย่างน้อย :min ตัวอักษร',
        'std_code.unique' => 'ข้อมูลซ้ำ',
        'std_name.required' => 'กรุณากรอกข้อมูล',
        'std_name.min' => 'ต้องมีอย่างน้อย :min ตัวอักษร',
        'std_phone.required' => 'กรุณากรอกข้อมูล',
        'std_phone.min' => 'ต้องมีอย่างน้อย :min ตัวอักษร',
        'std_phone.max' => 'ห้ามเกิน :max ตัวอักษร',
        'std_img.mimes' => 'รองรับ jpeg, png, jpg เท่านั้น !!',
        'std_img.max' => 'ขนาดไฟล์ไม่เกิน 5MB !!',
    ];

    // ตรวจสอบข้อมูลจากฟอร์มด้วย Validator
    $validator = Validator::make($request->all(), [
        'std_code' => [
                    'required',
                    'min:3',
                        Rule::unique('tbl_student', 'std_code')->ignore($id, 'id'), //ห้ามแก้ซ้ำ
            ],
        'std_name' => 'required|min:5',
        'std_phone' => 'required|min:10|max:10',
        'std_img' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
    ], $messages);

    // ถ้า validation ไม่ผ่าน ให้กลับไปหน้าฟอร์มพร้อมแสดง error และข้อมูลเดิม
    if ($validator->fails()) {
        return redirect('product/' . $id)
            ->withErrors($validator)
            ->withInput();
    }

    try {
        // ดึงข้อมูลสินค้าตามไอดี ถ้าไม่เจอจะ throw Exception
        $product = StudentModel::findOrFail($id);

        // ตรวจสอบว่ามีไฟล์รูปใหม่ถูกอัปโหลดมาหรือไม่
        if ($request->hasFile('product_img')) {
            // ถ้ามีรูปเดิมให้ลบไฟล์รูปเก่าออกจาก storage
            if ($product->product_img) {
                Storage::disk('public')->delete($product->product_img);
            }
            // บันทึกไฟล์รูปใหม่ลงโฟลเดอร์ 'uploads/product' ใน disk 'public'
            $imagePath = $request->file('product_img')->store('uploads/product', 'public');
            // อัปเดต path รูปภาพใหม่ใน model
            $product->product_img = $imagePath;
        }

        // อัปเดตชื่อสินค้า โดยใช้ strip_tags ป้องกันการแทรกโค้ด HTML/JS
        $product->product_name = strip_tags($request->product_name);
        // อัปเดตรายละเอียดสินค้า โดยใช้ strip_tags ป้องกันการแทรกโค้ด HTML/JS
        $product->product_detail = strip_tags($request->product_detail);
        // อัปเดตราคาสินค้า
        $product->product_price = $request->product_price;

        // บันทึกการเปลี่ยนแปลงในฐานข้อมูล
        $product->save();

        // แสดง SweetAlert แจ้งว่าบันทึกสำเร็จ
        Alert::success('Update Successfully');

        // เปลี่ยนเส้นทางกลับไปหน้ารายการสินค้า
        return redirect('/product');

    } catch (\Exception $e) {
       //return response()->json(['error' => $e->getMessage()], 500); //สำหรับ debug
        return view('errors.404');

         //return response()->json(['error' => $e->getMessage()], 500); //สำหรับ debug
        //return view('errors.404');
    }
} //update  



public function remove($id)
{
    try {
        $product = StudentModel::find($id); //คิวรี่เช็คว่ามีไอดีนี้อยู่ในตารางหรือไม่

        if (!$product) {   //ถ้าไม่มี
            Alert::error('Product not found.');
            return redirect('product');
        }

        //ถ้ามีภาพ ลบภาพในโฟลเดอร์ 
        if ($product->product_img && Storage::disk('public')->exists($product->product_img)) {
            Storage::disk('public')->delete($product->product_img);
        }

        // ลบข้อมูลจาก DB
        $product->delete();

        Alert::success('Delete Successfully');
        return redirect('product');

    } catch (\Exception $e) {
        Alert::error('เกิดข้อผิดพลาด: ' . $e->getMessage());
        return redirect('product');
    }
} //remove 



} //class
