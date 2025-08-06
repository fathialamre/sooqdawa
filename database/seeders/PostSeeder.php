<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Country;
use App\Models\Department;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get required data
        $departments = Department::all();
        $cities = City::all();
        $countries = Country::all();
        $users = User::all();

        if ($departments->isEmpty() || $cities->isEmpty() || $countries->isEmpty() || $users->isEmpty()) {
            $this->command->error('Please run Department, City, Country, and User seeders first.');
            return;
        }

        // Define sample posts with Arabic descriptions
        $posts = [
            [
                'description' => 'أدوية مضادة للالتهاب ومسكنات الألم عالية الجودة، مناسبة لعلاج الالتهابات المزمنة والحادة. تتميز بفعاليتها السريعة وأمانها العالي.',
                'company' => 'شركة الدواء الليبية',
                'activity' => 'تجارة الأدوية والمستحضرات الطبية',
                'phone' => '+218-21-123-4567',
                'address' => 'شارع الجمهورية، طرابلس',
                'price' => 25.50,
                'currency' => 'د.ل',
                'status' => 'published',
                'tags' => ['أدوية', 'مسكنات', 'مضاد للالتهاب', 'طبي'],
                'image' => '1.jpg',
            ],
            [
                'description' => 'مجموعة متنوعة من الفيتامينات والمكملات الغذائية الأساسية لتعزيز الصحة العامة ودعم جهاز المناعة. منتجات مستوردة من أوروبا.',
                'company' => 'مؤسسة الصحة المتقدمة',
                'activity' => 'استيراد وتوزيع المكملات الغذائية',
                'phone' => '+218-61-987-6543',
                'address' => 'منطقة الأندلس، بنغازي',
                'price' => 45.00,
                'currency' => 'د.ل',
                'status' => 'published',
                'tags' => ['فيتامينات', 'مكملات غذائية', 'صحة عامة', 'مناعة'],
                'image' => '2.jpeg',
            ],
            [
                'description' => 'أدوية القلب والأوعية الدموية المتخصصة لعلاج ارتفاع ضغط الدم وأمراض القلب. منتجات معتمدة من منظمة الصحة العالمية.',
                'company' => 'دار الشفاء الطبية',
                'activity' => 'توريد الأدوية المتخصصة',
                'phone' => '+218-51-456-7890',
                'address' => 'شارع عمر المختار، مصراته',
                'price' => 120.00,
                'currency' => 'د.ل',
                'status' => 'published',
                'tags' => ['قلب', 'ضغط دم', 'أوعية دموية', 'متخصص'],
                'image' => '3.jpg',
            ],
            [
                'description' => 'مضادات حيوية واسعة المجال فعالة ضد البكتيريا المختلفة. تستخدم في علاج الالتهابات الجهازية والموضعية بأمان تام.',
                'company' => 'المختبرات الطبية الحديثة',
                'activity' => 'إنتاج وتطوير المضادات الحيوية',
                'phone' => '+218-92-234-5678',
                'address' => 'المنطقة الصناعية، الزاوية',
                'price' => 35.75,
                'currency' => 'د.ل',
                'status' => 'published',
                'tags' => ['مضادات حيوية', 'بكتيريا', 'التهابات', 'علاج'],
                'image' => '4.jpg',
            ],
            [
                'description' => 'أدوية الجهاز التنفسي لعلاج الربو والتهاب الشعب الهوائية. تشمل البخاخات والأقراص والشراب للأطفال والكبار.',
                'company' => 'شركة النسيم الطبية',
                'activity' => 'تخصص في أدوية الجهاز التنفسي',
                'phone' => '+218-21-345-6789',
                'address' => 'حي الأندلس، طرابلس',
                'price' => 28.25,
                'currency' => 'دولار',
                'status' => 'draft',
                'tags' => ['تنفسي', 'ربو', 'شعب هوائية', 'بخاخات'],
                'image' => '1.jpg', // Reuse images
            ],
            [
                'description' => 'مستحضرات العناية بالبشرة والجلد، تشمل كريمات علاج الأكزيما والصدفية والالتهابات الجلدية المختلفة.',
                'company' => 'مركز الجمال الطبي',
                'activity' => 'مستحضرات التجميل العلاجية',
                'phone' => '+218-61-567-8901',
                'address' => 'شارع الاستقلال، بنغازي',
                'price' => 55.00,
                'currency' => 'يورو',
                'status' => 'published',
                'tags' => ['جلدية', 'بشرة', 'أكزيما', 'صدفية'],
                'image' => '2.jpeg',
            ],
        ];

        $imagesPath = database_path('seeders/resources/drug_images');

        foreach ($posts as $index => $postData) {
            // Create post
            $post = Post::create([
                'department_id' => $departments->where('name', 'الأدوية')->first()?->id ?? $departments->random()->id,
                'company' => $postData['company'],
                'city_id' => $cities->random()->id,
                'country_id' => $countries->random()->id,
                'address' => $postData['address'],
                'number_of_views' => rand(10, 500),
                'activity' => $postData['activity'],
                'phone' => $postData['phone'],
                'description' => $postData['description'],
                'price' => $postData['price'],
                'currency' => $postData['currency'],
                'user_id' => $users->random()->id,
                'status' => $postData['status'],
                'tags' => $postData['tags'],
            ]);

            // Attach image if file exists
            $imagePath = $imagesPath . '/' . $postData['image'];
            if (File::exists($imagePath)) {
                $post->addMedia($imagePath)
                    ->preservingOriginal()
                    ->toMediaCollection('images');
                
                $this->command->info("Added image {$postData['image']} to post: " . substr($postData['description'], 0, 50) . '...');
            } else {
                $this->command->warn("Image not found: {$imagePath}");
            }
        }

        $this->command->info('Post seeder completed successfully! Created ' . count($posts) . ' posts.');
    }
}
