<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all posts and users
        $posts = Post::all();
        $users = User::whereType('customer')->get();

        if ($posts->isEmpty()) {
            $this->command->error('Please run PostSeeder first.');
            return;
        }

        if ($users->isEmpty()) {
            $this->command->error('Please run CustomerSeeder first.');
            return;
        }

        // Sample comments in Arabic
        $commentTexts = [
            'منتج ممتاز وجودة عالية جداً، أنصح بشرائه بقوة.',
            'سعر مناسب والجودة كما هو متوقع، راضي عن الشراء.',
            'وصل المنتج في الوقت المحدد وبحالة ممتازة.',
            'خدمة عملاء رائعة والتوصيل سريع جداً.',
            'المنتج مطابق للوصف تماماً، شكراً لكم.',
            'جودة ممتازة وسعر منافس، سأعود للشراء مرة أخرى.',
            'منتج رائع وفعال، لاحظت النتائج من أول استخدام.',
            'التعبئة والتغليف احترافي والمنتج آمن.',
            'أنصح الجميع بهذا المنتج، فعلاً يستحق الثمن.',
            'خدمة سريعة ومنتج أصلي، راضي جداً عن التجربة.',
            'السعر مرتفع قليلاً ولكن الجودة تستحق ذلك.',
            'منتج ممتاز للاستخدام اليومي، سهل الاستعمال.',
            'وصل المنتج بسرعة والتغليف ممتاز.',
            'جربت منتجات كثيرة لكن هذا الأفضل حتى الآن.',
            'فريق الدعم الفني مفيد جداً وسريع في الرد.',
            'منتج آمن وفعال، أستخدمه منذ شهرين دون مشاكل.',
            'السعر مناسب جداً مقارنة بالصيدليات الأخرى.',
            'التسليم في الوقت المحدد والمنتج بحالة ممتازة.',
            'منتج أصلي 100% ومفعوله سريع وواضح.',
            'أنصح بهذا المتجر، منتجات أصلية وخدمة رائعة.',
            'استلمت المنتج بسرعة والجودة فوق التوقعات.',
            'فعال جداً وآمن للاستخدام اليومي.',
            'خدمة توصيل ممتازة والمنتج وصل في موعده.',
            'منتج رائع وسعر مناسب، راضي جداً عن الشراء.',
            'جودة عالية ومفعول سريع، أنصح به بقوة.',
            'المتجر موثوق والمنتجات أصلية ومضمونة.',
            'تم التسليم بسرعة والمنتج مطابق للمواصفات.',
            'منتج فعال وآمن، استخدمه العائلة كلها.',
            'سعر ممتاز وجودة عالية، سأطلب مرة أخرى.',
            'خدمة عملاء ممتازة ومنتج أصلي مضمون.',
            'وصل المنتج محفوظ بشكل جيد وبالموعد المحدد.',
            'منتج فعال ونتائج واضحة من أول استخدام.',
            'التغليف احترافي والمنتج آمن ومضمون.',
            'خدمة سريعة وموثوقة، راضي عن التجربة.',
            'منتج ممتاز بسعر مناسب، أنصح الجميع به.',
            'وصل بسرعة والجودة كما هو متوقع تماماً.',
            'فعال جداً وآمن للاستخدام المستمر.',
            'خدمة توصيل ممتازة والمنتج أصلي مضمون.',
            'أفضل سعر في السوق وجودة عالية.',
            'منتج رائع وخدمة عملاء مميزة.'
        ];

        $commentsCreated = 0;

        // Create 2-5 comments for each post
        foreach ($posts as $post) {
            $numComments = rand(2, 5);
            
            for ($i = 0; $i < $numComments; $i++) {
                Comment::create([
                    'comment' => $commentTexts[array_rand($commentTexts)],
                    'user_id' => $users->random()->id,
                    'post_id' => $post->id,
                    'created_at' => now()->subDays(rand(0, 30))->subHours(rand(0, 23)),
                ]);
                
                $commentsCreated++;
            }
        }

        $this->command->info("Comment seeder completed successfully! Created {$commentsCreated} comments for " . $posts->count() . " posts.");
    }
}