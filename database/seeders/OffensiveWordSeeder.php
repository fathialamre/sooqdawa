<?php

namespace Database\Seeders;

use App\Models\OffensiveWord;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OffensiveWordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $offensiveWords = [
            // High Severity - Very offensive words
            [
                'word' => 'كلب',
                'description' => 'كلمة مسيئة للحيوان',
                'severity' => 'high',
                'is_active' => true,
            ],
            [
                'word' => 'حيوان',
                'description' => 'كلمة مسيئة للإنسان',
                'severity' => 'high',
                'is_active' => true,
            ],
            [
                'word' => 'خنزير',
                'description' => 'كلمة مسيئة للإنسان',
                'severity' => 'high',
                'is_active' => true,
            ],
            [
                'word' => 'زبالة',
                'description' => 'كلمة مسيئة للإنسان',
                'severity' => 'high',
                'is_active' => true,
            ],
            [
                'word' => 'قذر',
                'description' => 'كلمة مسيئة للإنسان',
                'severity' => 'high',
                'is_active' => true,
            ],
            [
                'word' => 'عاهرة',
                'description' => 'كلمة مسيئة للمرأة',
                'severity' => 'high',
                'is_active' => true,
            ],
            [
                'word' => 'زاني',
                'description' => 'كلمة مسيئة للإنسان',
                'severity' => 'high',
                'is_active' => true,
            ],
            [
                'word' => 'زانية',
                'description' => 'كلمة مسيئة للمرأة',
                'severity' => 'high',
                'is_active' => true,
            ],
            [
                'word' => 'ابن الكلب',
                'description' => 'كلمة مسيئة للإنسان',
                'severity' => 'high',
                'is_active' => true,
            ],

            // Medium Severity - Moderately offensive words
            [
                'word' => 'غبي',
                'description' => 'كلمة مسيئة للإنسان',
                'severity' => 'medium',
                'is_active' => true,
            ],
            [
                'word' => 'أحمق',
                'description' => 'كلمة مسيئة للإنسان',
                'severity' => 'medium',
                'is_active' => true,
            ],
            [
                'word' => 'جاهل',
                'description' => 'كلمة مسيئة للإنسان',
                'severity' => 'medium',
                'is_active' => true,
            ],
            [
                'word' => 'متخلف',
                'description' => 'كلمة مسيئة للإنسان',
                'severity' => 'medium',
                'is_active' => true,
            ],
            [
                'word' => 'مخبول',
                'description' => 'كلمة مسيئة للإنسان',
                'severity' => 'medium',
                'is_active' => true,
            ],
            [
                'word' => 'مجنون',
                'description' => 'كلمة مسيئة للإنسان',
                'severity' => 'medium',
                'is_active' => true,
            ],
            [
                'word' => 'فاشل',
                'description' => 'كلمة مسيئة للإنسان',
                'severity' => 'medium',
                'is_active' => true,
            ],
            [
                'word' => 'كسول',
                'description' => 'كلمة مسيئة للإنسان',
                'severity' => 'medium',
                'is_active' => true,
            ],
            [
                'word' => 'بليد',
                'description' => 'كلمة مسيئة للإنسان',
                'severity' => 'medium',
                'is_active' => true,
            ],
            [
                'word' => 'أبله',
                'description' => 'كلمة مسيئة للإنسان',
                'severity' => 'medium',
                'is_active' => true,
            ],

            // Low Severity - Mildly offensive words
            [
                'word' => 'تافه',
                'description' => 'كلمة مسيئة للإنسان',
                'severity' => 'low',
                'is_active' => true,
            ],
            [
                'word' => 'ساذج',
                'description' => 'كلمة مسيئة للإنسان',
                'severity' => 'low',
                'is_active' => true,
            ],
            [
                'word' => 'بسيط',
                'description' => 'كلمة مسيئة للإنسان',
                'severity' => 'low',
                'is_active' => true,
            ],
            [
                'word' => 'سخيف',
                'description' => 'كلمة مسيئة للإنسان',
                'severity' => 'low',
                'is_active' => true,
            ],
            [
                'word' => 'مزعج',
                'description' => 'كلمة مسيئة للإنسان',
                'severity' => 'low',
                'is_active' => true,
            ],
            [
                'word' => 'مخيب',
                'description' => 'كلمة مسيئة للإنسان',
                'severity' => 'low',
                'is_active' => true,
            ],
            [
                'word' => 'مقرف',
                'description' => 'كلمة مسيئة للإنسان',
                'severity' => 'low',
                'is_active' => true,
            ],
            [
                'word' => 'مخيب',
                'description' => 'كلمة مسيئة للإنسان',
                'severity' => 'low',
                'is_active' => true,
            ],
            [
                'word' => 'ممل',
                'description' => 'كلمة مسيئة للإنسان',
                'severity' => 'low',
                'is_active' => true,
            ],
        ];

        $wordsCreated = 0;

        foreach ($offensiveWords as $wordData) {
            // Check if word already exists to avoid duplicates
            $existingWord = OffensiveWord::where('word', $wordData['word'])->first();
            
            if (!$existingWord) {
                OffensiveWord::create($wordData);
                $wordsCreated++;
            }
        }

        $this->command->info("OffensiveWord seeder completed successfully! Created {$wordsCreated} offensive words.");
    }
} 