Learn2Code by Bento Team

2213110329 ภูริณัฐ อรชุนวงศ์
2213110345 ศุภวิชญ์ พรหมเจริญ
2213110485 ณัฐพงศ์ มาสขา

========================================
ภาพรวมโปรเจกต์
========================================
Learn2Code คือเว็บตัวอย่างสำหรับแคตตาล็อกคอร์สเรียน/บทความด้านการเขียนโปรแกรม
พร้อมระบบหลังบ้านเพื่อจัดการข้อมูล โดยใช้ Laravel 12 + Bootstrap 5
รองรับทุกอุปกรณ์ (มือถือ/แท็บเล็ต/เดสก์ท็อป) และมีระบบสิทธิ์ (แอดมิน/สมาชิก)

เทคโนโลยีหลัก
- PHP 8.2+, Laravel 12.x
- MySQL/MariaDB (XAMPP)
- Bootstrap 5.3.x, Bootstrap Icons
- Google Fonts: Bebas Neue, Noto Sans Thai
- SweetAlert2
- Blade Templates + Asset ใน public/

โครงสร้างโดยย่อ
- app/Http/Controllers/           : คอนโทรลเลอร์ (Frontend/Backend)
- app/Models/                      : โมเดล Eloquent
- resources/views/                 : Blade views (layouts, frontend, admin/*)
- public/                          : ไฟล์สาธารณะ (css/, js/, images/)
- routes/web.php                   : เส้นทางหลักของเว็บ
- .env                             : ตั้งค่าฐานข้อมูล/ระบบ
- database/migrations, seeders     : ไฟล์สคีมา/ข้อมูลตั้งต้น (ถ้ามี)

========================================
ฟีเจอร์เด่น
========================================
Frontend (สาธารณะ)
- หน้า Landing/แสดงคอร์ส: การ์ดคอร์ส, เบนโต/กริด, สถิติโดยย่อ, องค์กร, ค้นหา
- รองรับ Bootstrap 5 + ไอคอน + ฟอนต์ไทย
- Responsive ครบทุกหน้าจอ

Backend (Admin)
- จัดการผู้ดูแลระบบ (Users/Admins): ค้นหา/จัดเรียง/แบ่งหน้า
- Action ปุ่มแก้ไข/ลบ + ป๊อปอัปยืนยันลบ (SweetAlert2/Modal)
- คลิกแถวเพื่อเข้าแก้ไข (row-select) — ใช้เส้นทาง /admin/users/{id}/edit
- จัดการคอร์ส/รีวิว (ตัวอย่าง): เพิ่ม/แก้ไข/ลบ, แสดงรายการ
- ระบบสิทธิ์: แยกสมาชิกทั่วไปกับผู้ดูแลด้วยฟิลด์ is_admin หรือ roles
- ปรับแต่งธีมสไตล์ Dark แบบ Card-UI + ขอบมน + เอฟเฟกต์เบาๆ

ส่วนประกอบ UI
- Navbar แบบ responsive
- ตารางข้อมูล (table-darkish, table-hover, row-selected)
- ฟอร์มค้นหา (มีไอคอน, โฟกัสชัดเจน)
- Badge แสดงบทบาท, Avatar/รูปโปรไฟล์
- Pagination พร้อมตัวเลขหน้าและสรุปจำนวนรายการ
- Favicon (วางใน public/images/... และใช้ href ไม่ใช่ ref)

========================================
บัญชีทดสอบ (Test Accounts)
========================================
Admin
- User:    ma.natthaphong.infj@gmail.com
- Pass:    12345678@Ab

Member
- User:    test@gmail.com
- Pass:    12345678

========================================
การติดตั้ง & รันบนเครื่อง (Local)
========================================
1) ติดตั้งเครื่องมือ
   - PHP 8.2+, Composer, MySQL/MariaDB (XAMPP), Node.js (ไม่บังคับ หากใช้ CDN แล้ว)
2) ดึงโค้ดแล้วติดตั้งแพ็กเกจ
   composer install
3) คัดลอกไฟล์สิ่งแวดล้อม
   cp .env.example .env
4) ตั้งค่า .env
   - DB_DATABASE=learn2code
   - DB_USERNAME=root
   - DB_PASSWORD= (ว่างถ้า XAMPP ค่าเริ่มต้น)
   - APP_URL=http://127.0.0.1:8000
5) สร้างคีย์แอป
   php artisan key:generate
6) สร้างตาราง/ข้อมูลตั้งต้น (ถ้ามีไฟล์ migration/seeder)
   php artisan migrate --seed
7) ลิงก์สตอเรจ (ถ้ามีอัปโหลดไฟล์)
   php artisan storage:link
8) รันเซิร์ฟเวอร์
   php artisan serve
9) เปิดเว็บ
   - Frontend: http://127.0.0.1:8000
   - Backend (ตัวอย่าง): http://127.0.0.1:8000/admin

ไฟล์สาธารณะ
- วางรูป/ไอคอนใน public/images/ (เช่น public/images/Assets/Learn2Code_Transparent.png)
- วาง CSS/JS แบบกำหนดเองใน public/css, public/js และอ้างถึงด้วย {{ asset('css/...') }}

========================================
เส้นทาง (Routes) ตัวอย่าง
========================================
สาธารณะ
- GET  /               -> หน้าแรก (courses/frontend)
- GET  /home           -> หน้าเดโม/สำรอง
- GET  /courses/...    -> รายละเอียดคอร์ส, ค้นหา

หลังบ้าน (ต้องล็อกอิน และต้องเป็นแอดมิน)
- GET   /admin/users                 -> รายการผู้ดูแล
- GET   /admin/users/create          -> ฟอร์มเพิ่ม
- POST  /admin/users                 -> บันทึกสร้าง
- GET   /admin/users/{id}/edit       -> แก้ไข
- PUT   /admin/users/{id}            -> อัปเดต
- DELETE/admin/users/{id}            -> ลบ

========================================
ลิขสิทธิ์ & ใบอนุญาต
========================================
โค้ดนี้จัดทำเพื่อการศึกษา/สาธิต สามารถดัดแปลงใช้งานภายในโปรเจกต์ของคุณได้ตามสมควร
โปรดตรวจสอบสิทธิ์ของภาพ/ฟอนต์/ไอคอนที่ใช้งานก่อนเผยแพร่จริง
