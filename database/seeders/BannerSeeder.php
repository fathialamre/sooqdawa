<?php

namespace Database\Seeders;

use App\Enums\BannerType;
use App\Models\Banner;
use App\Models\Post;
use App\Models\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class BannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get available banner images
        $bannerImagesPath = database_path('seeders/resources/banners');
        $bannerImages = [];
        
        if (File::exists($bannerImagesPath)) {
            $bannerImages = File::files($bannerImagesPath);
        }

        if (empty($bannerImages)) {
            $this->command->warn('No banner images found in database/seeders/resources/banners/');
            $this->command->info('Creating banners without images...');
        }

        $this->command->info('Found ' . count($bannerImages) . ' banner images');

        // Get some posts and departments for polymorphic relations
        $posts = Post::limit(3)->get();
        $departments = Department::limit(2)->get();

        $bannersData = [];

        // Create banners for each type
        
        // 1. Post banners
        if ($posts->isNotEmpty()) {
            foreach ($posts as $index => $post) {
                $bannersData[] = [
                    'type' => BannerType::POST,
                    'model_id' => $post->id,
                    'model' => Post::class,
                    'is_active' => true,
                    'external_link' => null,
                ];
            }
        }

        // 2. Department banners  
        if ($departments->isNotEmpty()) {
            foreach ($departments as $index => $department) {
                $bannersData[] = [
                    'type' => BannerType::DEPARTMENT,
                    'model_id' => $department->id,
                    'model' => Department::class,
                    'is_active' => true,
                    'external_link' => null,
                ];
            }
        }

        // 3. External link banners
        $externalLinks = [
            'https://example.com',
            'https://google.com',
            'https://github.com',
        ];

        foreach ($externalLinks as $link) {
            $bannersData[] = [
                'type' => BannerType::EXTERNAL_LINK,
                'model_id' => null,
                'model' => null,
                'is_active' => true,
                'external_link' => $link,
            ];
        }

        // 4. None type banners
        for ($i = 1; $i <= 2; $i++) {
            $bannersData[] = [
                'type' => BannerType::NONE,
                'model_id' => null,
                'model' => null,
                'is_active' => true,
                'external_link' => null,
            ];
        }

        // Create banners and attach images
        $createdBanners = 0;
        foreach ($bannersData as $index => $bannerData) {
            $banner = Banner::create($bannerData);

            $createdBanners++;
            
            // Attach random banner image if available
            if (!empty($bannerImages)) {
                $randomImage = $bannerImages[array_rand($bannerImages)];
                
                try {
                    $banner->addMedia($randomImage->getPathname())
                        ->preservingOriginal()
                        ->usingName('Banner Image')
                        ->toMediaCollection('banner_image');
                    
                    $this->command->info("Attached image to banner {$banner->id}");
                } catch (\Exception $e) {
                    $this->command->error("Failed to attach image to banner {$banner->id}: " . $e->getMessage());
                }
            }
        }

        $this->command->info("Banner seeder completed successfully! Created {$createdBanners} banners with images.");
        $this->command->info("Banner types created:");
        $this->command->info("- Post banners: " . count($posts));
        $this->command->info("- Department banners: " . count($departments));
        $this->command->info("- External link banners: " . count($externalLinks));
        $this->command->info("- None type banners: 2");
    }
}