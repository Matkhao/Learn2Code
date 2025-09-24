<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\AdminModel;
use Illuminate\Pagination\Paginator;

class AdminController extends Controller
{

public function index()
{
    try {
        Paginator::useBootstrap();
        $AdminList = AdminModel::orderBy('id', 'desc')->paginate(10); //order by & pagination
        return view('admin.list', compact('AdminList'));
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500); //สำหรับ debug
         //return view('errors.404');
    }
}

    public function adding() {
        return view('admin.create');
    }

    public function create(Request $request)
    {
        // echo '<pre>';
        // dd($_POST);
        // exit();

        //vali msg 
        $messages = [
            'admin_username.required' => 'กรุณากรอกข้อมูล',
            'admin_username.email' => 'รูปแบบอีเมลไม่ถูกต้อง',
            'admin_username.unique' => 'Email ซ้ำ เพิ่มใหม่อีกครั้ง',

            'admin_password.required' => 'กรุณากรอกข้อมูล',
            'admin_password.min' => 'กรอกข้อมูลขั้นต่ำ :min ตัว',
 
            'admin_name.required' => 'กรุณากรอกข้อมูล',
            'admin_name.min' =>  'กรอกข้อมูลขั้นต่ำ :min ตัว',
        ];

        //rule 
        $validator = Validator::make($request->all(), [
            'admin_username' => 'required|email|unique:tbl_admin',
            'admin_password' => 'required|min:3',
            'admin_name' => 'required|min:3',
        ], $messages);

        //check vali 
        if ($validator->fails()) {
            return redirect('admin/adding')
                ->withErrors($validator)
                ->withInput();
        }

        try {

            //ปลอดภัย: กัน XSS ที่มาจาก <script>, <img onerror=...> ได้
            AdminModel::create([
                'admin_name' => strip_tags($request->input('admin_name')),
                'admin_username' => strip_tags($request->input('admin_username')),
                'admin_password' => bcrypt($request->input('admin_password')),
            ]);
            // แสดง Alert ก่อน return
            Alert::success('เพิ่มข้อมูลสำเร็จ');
            return redirect('/admin');
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500); //สำหรับ debug
            //return view('errors.404');
        }
    } //fun create



 public function edit($id)
    {
        try {
            //query data for form edit 
            $test = TestModel::findOrFail($id); // ใช้ findOrFail เพื่อให้เจอหรือ 404
            if (isset($test)) {
                $id = $test->id;
                $name = $test->name;
                $phone = $test->phone;
                $email = $test->email;
                return view('test.edit', compact('id', 'name', 'phone', 'email'));
            }
        } catch (\Exception $e) {
            //return response()->json(['error' => $e->getMessage()], 500); //สำหรับ debug
            return view('errors.404');
        }
    } //func edit


 public function update($id, Request $request)
    {
        //vali msg 
        $messages = [
            'name.required' => 'กรุณากรอกข้อมูล',
            'name.min' => 'กรอกข้อมูลขั้นต่ำ :min ตัวอักษร',
            'name.unique' => 'ชื่อนี้ถูกใช้งานแล้ว',  //ป้องกันแก้ซ้ำกับ row อื่นๆ จ้าาา

            'phone.required' => 'กรุณากรอกข้อมูล',
            'phone.min' => 'กรอกข้อมูลขั้นต่ำ :min ตัว',
            'phone.max' => 'กรอกข้อมูลสูงสุดไม่เกิน :max ตัว',
            
            'email.required' => 'กรุณากรอกข้อมูล',
            'email.email' => 'รูปแบบอีเมลไม่ถูกต้อง',
        ];

        //rule
        $validator = Validator::make($request->all(), [
            'name' => [
                    'required',
                    'min:3',
                        Rule::unique('tbl_test', 'name')->ignore($id, 'id'), //ห้ามแก้ซ้ำ
            ],

            'phone' => 'required|min:10|max:10',
            'email' => 'required|email',
    ], $messages);

    //check 
        if ($validator->fails()) {
            return redirect('test/' . $id)
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $test = TestModel::find($id);
            $test->update([
                    'name' => strip_tags($request->input('name')), //column update 
                    'phone' => strip_tags($request->input('phone')),
                    'email' => strip_tags($request->input('email')),
                ]);
            // แสดง Alert ก่อน return
            Alert::success('ปรับปรุงข้อมูลสำเร็จ');
            return redirect('/test');
        } catch (\Exception $e) {
            //return response()->json(['error' => $e->getMessage()], 500); //สำหรับ debug
            return view('errors.404');
        }
    } //fun update 


    public function remove($id)
    {
        try {
            $admin = AdminModel::find($id);  //query หาว่ามีไอดีนี้อยู่จริงไหม 
            $admin->delete();
            Alert::success('ลบข้อมูลสำเร็จ');
            return redirect('/admin');
        } catch (\Exception $e) {
            //return response()->json(['error' => $e->getMessage()], 500); //สำหรับ debug
            return view('errors.404');
        }
    } //remove 


     public function reset($id)
    {
        try {
            //query data for form edit 
            $admin = AdminModel::findOrFail($id); // ใช้ findOrFail เพื่อให้เจอหรือ 404
            if (isset($admin)) {

                $id = $admin->id;
                $admin_name = $admin->admin_name;
                $admin_username = $admin->admin_username;

                return view('admin.editPassword', compact('id', 'admin_name', 'admin_username'));
            }
        } catch (\Exception $e) {
            //return response()->json(['error' => $e->getMessage()], 500); //สำหรับ debug
            return view('errors.404');
        }
    } //func reset

     public function resetPassword($id, Request $request)
    {
        //vali msg 
        $messages = [
            'password.required' => 'กรุณากรอกข้อมูล',
            'password.min' => 'กรอกข้อมูลขั้นต่ำ :min ตัวอักษร',
            'password.confirmed' => 'รหัสผ่านไม่ตรงกัน',  

            'password_confirmation.required' => 'กรุณากรอกข้อมูล',
            'password_confirmation.min' => 'กรอกข้อมูลขั้นต่ำ :min ตัว',
        ];

        //rule
        $validator = Validator::make($request->all(), [
            'password' => 'required|min:3|confirmed',
            'password_confirmation' => 'required|min:3',
    ], $messages);

    //check 
        if ($validator->fails()) {
            return redirect('admin/reset/' . $id)
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $admin = AdminModel::find($id);
            $admin->update([
                    'admin_password' => bcrypt($request->input('password')),
                ]);
            // แสดง Alert ก่อน return
            Alert::success('แก้ไขรหัสผ่านสำเร็จ');
            return redirect('/admin');
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500); //สำหรับ debug
           // return view('errors.404');
        }
    } //fun update 


} //class
