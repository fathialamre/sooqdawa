<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Country;
use App\Models\Department;
use App\Models\Post;
use App\Models\User;
use App\Enums\PostStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class PostSeederUpdated extends Seeder
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
        $users = User::whereType('customer')->get(); // Only get customers

        if ($departments->isEmpty()) {
            $this->command->error('Please run DepartmentSeeder first.');
            return;
        }
        
        if ($cities->isEmpty()) {
            $this->command->error('Please run CitySeeder first.');
            return;
        }
        
        if ($countries->isEmpty()) {
            $this->command->error('Please run CountriesSeeder first.');
            return;
        }
        
        if ($users->isEmpty()) {
            $this->command->error('Please run CustomerSeeder first.');
            return;
        }

        // Define sample posts with Arabic descriptions - expanded list
        $posts = [
            [
                'description' => 'أدوية مضادة للالتهاب ومسكنات الألم عالية الجودة، مناسبة لعلاج الالتهابات المزمنة والحادة. تتميز بفعاليتها السريعة وأمانها العالي.',
                'company' => 'شركة الدواء الليبية',
                'activity' => 'تجارة الأدوية والمستحضرات الطبية',
                'phone' => '+218-21-123-4567',
                'address' => 'شارع الجمهورية، طرابلس',
                'price' => 25.50,
                'currency' => 'د.ل',
                'status' => PostStatus::PUBLISHED,
                'tags' => ['أدوية', 'مسكنات', 'مضاد للالتهاب', 'طبي'],
            ],
            [
                'description' => 'مجموعة متنوعة من الفيتامينات والمكملات الغذائية الأساسية لتعزيز الصحة العامة ودعم جهاز المناعة. منتجات مستوردة من أوروبا.',
                'company' => 'مؤسسة الصحة المتقدمة',
                'activity' => 'استيراد وتوزيع المكملات الغذائية',
                'phone' => '+218-61-987-6543',
                'address' => 'منطقة الأندلس، بنغازي',
                'price' => 45.00,
                'currency' => 'د.ل',
                'status' => PostStatus::PUBLISHED,
                'tags' => ['فيتامينات', 'مكملات غذائية', 'صحة عامة', 'مناعة'],
            ],
            [
                'description' => 'أدوية القلب والأوعية الدموية المتخصصة لعلاج ارتفاع ضغط الدم وأمراض القلب. منتجات معتمدة من منظمة الصحة العالمية.',
                'company' => 'دار الشفاء الطبية',
                'activity' => 'توريد الأدوية المتخصصة',
                'phone' => '+218-51-456-7890',
                'address' => 'شارع عمر المختار، مصراته',
                'price' => 120.00,
                'currency' => 'د.ل',
                'status' => PostStatus::PUBLISHED,
                'tags' => ['قلب', 'ضغط دم', 'أوعية دموية', 'متخصص'],
            ],
            [
                'description' => 'مضادات حيوية واسعة المجال فعالة ضد البكتيريا المختلفة. تستخدم في علاج الالتهابات الجهازية والموضعية بأمان تام.',
                'company' => 'المختبرات الطبية الحديثة',
                'activity' => 'إنتاج وتطوير المضادات الحيوية',
                'phone' => '+218-92-234-5678',
                'address' => 'المنطقة الصناعية، الزاوية',
                'price' => 35.75,
                'currency' => 'د.ل',
                'status' => PostStatus::PUBLISHED,
                'tags' => ['مضادات حيوية', 'بكتيريا', 'التهابات', 'علاج'],
            ],
            [
                'description' => 'أدوية الجهاز التنفسي لعلاج الربو والتهاب الشعب الهوائية. تشمل البخاخات والأقراص والشراب للأطفال والكبار.',
                'company' => 'شركة النسيم الطبية',
                'activity' => 'تخصص في أدوية الجهاز التنفسي',
                'phone' => '+218-21-345-6789',
                'address' => 'حي الأندلس، طرابلس',
                'price' => 28.25,
                'currency' => 'دولار',
                'status' => PostStatus::DRAFT,
                'tags' => ['تنفسي', 'ربو', 'شعب هوائية', 'بخاخات'],
            ],
            [
                'description' => 'مستحضرات العناية بالبشرة والجلد، تشمل كريمات علاج الأكزيما والصدفية والالتهابات الجلدية المختلفة.',
                'company' => 'مركز الجمال الطبي',
                'activity' => 'مستحضرات التجميل العلاجية',
                'phone' => '+218-61-567-8901',
                'address' => 'شارع الاستقلال، بنغازي',
                'price' => 55.00,
                'currency' => 'يورو',
                'status' => PostStatus::PUBLISHED,
                'tags' => ['جلدية', 'بشرة', 'أكزيما', 'صدفية'],
            ],
            [
                'description' => 'أدوية الجهاز الهضمي لعلاج القرحة والحموضة والتهاب المعدة. تتضمن أقراص وشراب سريع المفعول.',
                'company' => 'صيدلية الأمل الطبية',
                'activity' => 'تجارة أدوية الجهاز الهضمي',
                'phone' => '+218-21-678-9012',
                'address' => 'شارع الشط، طرابلس',
                'price' => 18.50,
                'currency' => 'د.ل',
                'status' => PostStatus::PUBLISHED,
                'tags' => ['جهاز هضمي', 'قرحة', 'حموضة', 'معدة'],
            ],
            [
                'description' => 'أدوية طب الأطفال والرضع، تشمل أدوية الحمى والمغص والتطعيمات. منتجات آمنة وموثوقة للأطفال.',
                'company' => 'مركز طب الأطفال المتقدم',
                'activity' => 'تخصص في أدوية الأطفال',
                'phone' => '+218-61-789-0123',
                'address' => 'شارع الجامعة، بنغازي',
                'price' => 22.00,
                'currency' => 'د.ل',
                'status' => PostStatus::PUBLISHED,
                'tags' => ['أطفال', 'رضع', 'حمى', 'مغص', 'تطعيمات'],
            ],
            [
                'description' => 'أدوية الأمراض النفسية والعصبية لعلاج الاكتئاب والقلق والأرق. تحت إشراف طبي متخصص.',
                'company' => 'عيادة الصحة النفسية',
                'activity' => 'تخصص في العلاج النفسي',
                'phone' => '+218-92-890-1234',
                'address' => 'شارع الفتح، مصراته',
                'price' => 75.00,
                'currency' => 'د.ل',
                'status' => PostStatus::DRAFT,
                'tags' => ['نفسي', 'عصبي', 'اكتئاب', 'قلق', 'أرق'],
            ],
            [
                'description' => 'أدوية العظام والمفاصل لعلاج الروماتيزم والتهاب المفاصل وهشاشة العظام. حلول متكاملة لصحة العظام.',
                'company' => 'مركز العظام والمفاصل',
                'activity' => 'تخصص في أمراض العظام',
                'phone' => '+218-51-901-2345',
                'address' => 'شارع النصر، الزاوية',
                'price' => 85.25,
                'currency' => 'د.ل',
                'status' => PostStatus::PUBLISHED,
                'tags' => ['عظام', 'مفاصل', 'روماتيزم', 'هشاشة'],
            ],
            [
                'description' => 'أدوية الغدد الصماء والسكري لتنظيم مستوى السكر في الدم والهرمونات. منتجات حديثة وفعالة.',
                'company' => 'مركز السكري والغدد',
                'activity' => 'تخصص في أمراض الغدد الصماء',
                'phone' => '+218-21-012-3456',
                'address' => 'شارع الحرية، طرابلس',
                'price' => 95.00,
                'currency' => 'د.ل',
                'status' => PostStatus::PUBLISHED,
                'tags' => ['سكري', 'غدد صماء', 'هرمونات', 'أنسولين'],
            ],
            [
                'description' => 'أدوية الكلى والمسالك البولية لعلاج التهابات المسالك البولية وحصوات الكلى. علاج متخصص وآمن.',
                'company' => 'عيادة المسالك البولية',
                'activity' => 'تخصص في أمراض الكلى',
                'phone' => '+218-61-123-4567',
                'address' => 'شارع المدينة، بنغازي',
                'price' => 42.50,
                'currency' => 'د.ل',
                'status' => PostStatus::PUBLISHED,
                'tags' => ['كلى', 'مسالك بولية', 'التهابات', 'حصوات'],
            ],
            [
                'description' => 'أدوية العيون والأذن والأنف والحنجرة. قطرات وبخاخات ومراهم لعلاج الالتهابات والحساسية.',
                'company' => 'مركز طب العيون والأنف',
                'activity' => 'تخصص في أمراض الحواس',
                'phone' => '+218-92-234-5678',
                'address' => 'شارع الوحدة، مصراته',
                'price' => 32.75,
                'currency' => 'د.ل',
                'status' => PostStatus::PUBLISHED,
                'tags' => ['عيون', 'أذن', 'أنف', 'حنجرة', 'قطرات'],
            ],
            [
                'description' => 'أدوية النساء والتوليد لصحة المرأة خلال الحمل والولادة وما بعد الولادة. منتجات آمنة ومتخصصة.',
                'company' => 'مركز صحة المرأة',
                'activity' => 'تخصص في طب النساء والتوليد',
                'phone' => '+218-51-345-6789',
                'address' => 'شارع الكرامة، الزاوية',
                'price' => 68.00,
                'currency' => 'د.ل',
                'status' => PostStatus::PUBLISHED,
                'tags' => ['نساء', 'توليد', 'حمل', 'ولادة', 'صحة المرأة'],
            ],
            [
                'description' => 'أدوية الأورام والعلاج الكيماوي تحت إشراف طبي صارم. أحدث الأدوية المستوردة لعلاج السرطان.',
                'company' => 'مركز الأورام المتقدم',
                'activity' => 'تخصص في علاج الأورام',
                'phone' => '+218-21-456-7890',
                'address' => 'شارع الطبي، طرابلس',
                'price' => 250.00,
                'currency' => 'دولار',
                'status' => PostStatus::PUBLISHED,
                'tags' => ['أورام', 'سرطان', 'كيماوي', 'متخصص'],
            ],
        ];

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
                'user_id' => $users->random()->id, // Random customer user
                'status' => $postData['status'],
                'tags' => $postData['tags'],
            ]);

            $this->command->info("Created post: " . substr($postData['description'], 0, 50) . '...');
        }

        $this->command->info('Enhanced Post seeder completed successfully! Created ' . count($posts) . ' posts for random customers.');
    }
}