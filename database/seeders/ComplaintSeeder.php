<?php

namespace Database\Seeders;

use App\Models\Complaint;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ComplaintSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all customer users
        $users = User::whereType('customer')->get();

        if ($users->isEmpty()) {
            $this->command->error('Please run CustomerSeeder first.');
            return;
        }

        $complaintsCreated = 0;
        $complaintTemplates = [
            'أواجه مشاكل في تسجيل الدخول إلى التطبيق. تظهر لي رسالة خطأ باستمرار.',
            'نظام الدفع لا يعمل بشكل صحيح. حاولت إجراء عملية شراء لكنها فشلت.',
            'لا أستطيع رفع صورة الملف الشخصي. زر الرفع لا يستجيب.',
            'التطبيق بطيء جدًا ويتعطل كثيرًا. الرجاء إصلاح مشاكل الأداء.',
            'لدي مشكلة في نظام القسائم. رمز القسيمة لا يتم قبوله.',
            'وظيفة البحث لا تعمل بشكل صحيح. تظهر نتائج غير ذات صلة.',
            'أرغب في الإبلاغ عن خطأ في نظام الإشعارات. لا تصلني إشعارات الدفع.',
            'وقت استجابة دعم العملاء بطيء جدًا. الرجاء تحسين الخدمة.',
            'لدي اقتراح لتحسين واجهة المستخدم. التصميم الحالي مربك.',
            'هناك مشكلة في عرض رصيد المحفظة. تظهر مبالغ غير صحيحة.',
            'لا أستطيع الوصول إلى بعض الميزات التي يجب أن تكون متاحة لنوع حسابي.',
            'التطبيق يستهلك الكثير من البطارية. الرجاء تحسين الأداء.',
            'لدي شكوى بخصوص محتوى غير لائق وجدته على المنصة.',
            'عملية التسجيل معقدة جدًا. الرجاء تبسيطها.',
            'أواجه صعوبة في وظيفة إعادة تعيين كلمة المرور.',
        ];

        // Create complaints for each user (1-3 complaints per user)
        foreach ($users as $user) {
            $complaintCount = rand(1, 3);
            
            for ($i = 0; $i < $complaintCount; $i++) {
                $status = rand(1, 10) <= 7 ? 'open' : 'resolved'; // 70% open, 30% resolved
                
                Complaint::create([
                    'user_id' => $user->id,
                    'body' => $complaintTemplates[array_rand($complaintTemplates)],
                    'status' => $status,
                    'created_at' => now()->subDays(rand(0, 60))->subHours(rand(0, 23)),
                    'updated_at' => now()->subDays(rand(0, 60))->subHours(rand(0, 23)),
                ]);
                
                $complaintsCreated++;
            }
        }

        $this->command->info("Complaint seeder completed successfully! Created {$complaintsCreated} complaints for " . $users->count() . " users.");
    }
} 