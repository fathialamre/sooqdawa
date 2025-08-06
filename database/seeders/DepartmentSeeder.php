<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define departments based on image names
        $departments = [
            [
                'name' => 'الأدوية',
                'name_en' => 'Medicines',
                'description' => 'قسم متخصص في توفير جميع أنواع الأدوية والعلاجات الطبية المعتمدة والمرخصة من وزارة الصحة',
                'image' => 'الادوية.png',
                'is_active' => true,
            ],
            [
                'name' => 'طب الأسنان',
                'name_en' => 'Dentistry',
                'description' => 'قسم متخصص في معدات وأدوات طب الأسنان والمواد المستخدمة في العلاج والتجميل السني',
                'image' => 'طب الاسنان.png',
                'is_active' => true,
            ],
            [
                'name' => 'بنك الدم',
                'name_en' => 'Blood Bank',
                'description' => 'قسم متخصص في معدات وأدوات بنك الدم وحفظ وتحليل عينات الدم والمكونات ذات الصلة',
                'image' => 'بنك الدم.png',
                'is_active' => true,
            ],
            [
                'name' => 'وظائف شاغرة',
                'name_en' => 'Job Vacancies',
                'description' => 'قسم متخصص في الإعلان عن الوظائف الشاغرة في المجال الطبي والصحي وتوظيف الكوادر المتخصصة',
                'image' => 'وظائف شاغرة.png',
                'is_active' => true,
            ],
            [
                'name' => 'معدات المختبرات',
                'name_en' => 'Laboratory Equipment',
                'description' => 'قسم متخصص في توفير معدات وأجهزة المختبرات الطبية والتحاليل الطبية والكيميائية',
                'image' => 'معدات المختبرات.png',
                'is_active' => true,
            ],
            [
                'name' => 'الصيدليات',
                'name_en' => 'Pharmacies',
                'description' => 'قسم متخصص في معدات الصيدليات وأدوات تحضير وتوزيع الأدوية والمستحضرات الصيدلانية',
                'image' => 'الصيدليات.png',
                'is_active' => true,
            ],
            [
                'name' => 'معدات الإسعاف',
                'name_en' => 'Emergency Equipment',
                'description' => 'قسم متخصص في معدات الإسعاف والطوارئ الطبية وأدوات الإنقاذ والرعاية الطارئة',
                'image' => 'معدات الاسعاف.png',
                'is_active' => true,
            ],
        ];

        $imagesPath = database_path('seeders/resources/images');

        foreach ($departments as $departmentData) {
            // Use Arabic name as primary name
            $department = Department::create([
                'name' => $departmentData['name'],
                'description' => $departmentData['description'],
                'is_active' => $departmentData['is_active'],
            ]);

            // Attach image if file exists
            $imagePath = $imagesPath . '/' . $departmentData['image'];
            if (File::exists($imagePath)) {
                $department
                    ->addMedia($imagePath)
                    ->preservingOriginal()
                    ->toMediaCollection('default');
                
                $this->command->info("Added image for department: {$departmentData['name']}");
            } else {
                $this->command->warn("Image not found for department: {$departmentData['name']} at {$imagePath}");
            }
        }

        $this->command->info('Department seeder completed successfully!');
    }
}
