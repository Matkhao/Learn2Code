<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\CategoryModel;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ตรวจสอบว่ามีข้อมูลอยู่แล้วหรือไม่ ถ้ามีก็ skip
        if (CategoryModel::count() > 0) {
            $this->command->info('Categories already exist. Skipping...');
            return;
        }

        // ข้อมูลหมวดหมู่ที่จำเป็นตาม courses ที่มีอยู่
        $categories = [
            ['category_id' => 1, 'name' => 'Frontend Development', 'icon' => 'fas fa-code'],
            ['category_id' => 5, 'name' => 'Data Science', 'icon' => 'fas fa-chart-bar'],
            ['category_id' => 9, 'name' => 'Programming Languages', 'icon' => 'fas fa-laptop-code'],
            ['category_id' => 10, 'name' => 'Web Development', 'icon' => 'fas fa-globe'],
            ['category_id' => 11, 'name' => 'Game Development', 'icon' => 'fas fa-gamepad'],
            ['category_id' => 15, 'name' => 'DevOps & Tools', 'icon' => 'fas fa-tools'],

            // หมวดหมู่เพิ่มเติม
            ['category_id' => 2, 'name' => 'Backend Development', 'icon' => 'fas fa-server'],
            ['category_id' => 3, 'name' => 'Mobile Development', 'icon' => 'fas fa-mobile-alt'],
            ['category_id' => 4, 'name' => 'Database', 'icon' => 'fas fa-database'],
            ['category_id' => 6, 'name' => 'Machine Learning', 'icon' => 'fas fa-brain'],
            ['category_id' => 7, 'name' => 'Cybersecurity', 'icon' => 'fas fa-shield-alt'],
            ['category_id' => 8, 'name' => 'Cloud Computing', 'icon' => 'fas fa-cloud'],
            ['category_id' => 12, 'name' => 'UI/UX Design', 'icon' => 'fas fa-paint-brush'],
            ['category_id' => 13, 'name' => 'Digital Marketing', 'icon' => 'fas fa-bullhorn'],
            ['category_id' => 14, 'name' => 'Project Management', 'icon' => 'fas fa-tasks'],
        ];

        foreach ($categories as $category) {
            CategoryModel::create([
                'category_id' => $category['category_id'],
                'name' => $category['name'],
                'icon' => $category['icon'],
                'created_at' => now(),
            ]);
        }

        $this->command->info('Categories seeded successfully!');
    }
}