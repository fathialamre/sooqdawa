<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $plans = [
            [
                'name' => 'باقة السيلفر',
                'price' => 99.99,
                'duration_months' => 1,
                'description' => 'الباقة الفضية - مثالية للمستخدمين الجدد. تتضمن الميزات الأساسية والدعم الفني على مدار الساعة.',
                'number_of_posts' => 10,
                'feature_posts' => '<ul><li>منشورات أساسية</li><li>دعم فني أساسي</li><li>إحصائيات بسيطة</li></ul>',
                'is_active' => true,
            ],
            [
                'name' => 'الباقة الذهبية',
                'price' => 199.99,
                'duration_months' => 3,
                'description' => 'الباقة الذهبية - رائعة للمستخدمين المتقدمين. تتضمن ميزات متقدمة ودعم ذو أولوية وتحليلات مفصلة.',
                'number_of_posts' => 50,
                'feature_posts' => '<ul><li>منشورات متقدمة</li><li>دعم فني ذو أولوية</li><li>تحليلات مفصلة</li><li>ميزات إضافية</li></ul>',
                'is_active' => true,
            ],
            [
                'name' => 'الباقة الماسية',
                'price' => 399.99,
                'duration_months' => 6,
                'description' => 'الباقة الماسية - للحصول على جميع الميزات. تتضمن كل شيء بالإضافة إلى التكاملات المخصصة والدعم المميز.',
                'number_of_posts' => 200,
                'feature_posts' => '<ul><li>منشورات غير محدودة</li><li>دعم فني مميز</li><li>تحليلات متقدمة</li><li>تكاملات مخصصة</li><li>ميزات حصرية</li></ul>',
                'is_active' => true,
            ],
        ];

        foreach ($plans as $planData) {
            $plan = Plan::create($planData);
            
            // Add the corresponding image to the plan
            $imageName = $planData['name'] . '.png';
            $imagePath = public_path('data/plans/' . $imageName);
            
            if (file_exists($imagePath)) {
                $plan->addMedia($imagePath)
                    ->preservingOriginal()
                    ->toMediaCollection('avatar');
            }
        }

        $this->command->info('Plan seeder completed successfully! Created ' . count($plans) . ' plans.');
    }
}
