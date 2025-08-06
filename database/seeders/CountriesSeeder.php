<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CountriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $countries = [
            // Main countries first
            ['name' => 'ليبيا', 'iso' => 'LY'],
            ['name' => 'تونس', 'iso' => 'TN'],
            ['name' => 'مصر', 'iso' => 'EG'],
            ['name' => 'تركيا', 'iso' => 'TR'],
            ['name' => 'الأردن', 'iso' => 'JO'],
            ['name' => 'المملكة العربية السعودية', 'iso' => 'SA'],
            ['name' => 'لبنان', 'iso' => 'LB'],
            ['name' => 'مالطا', 'iso' => 'MT'],
            ['name' => 'الولايات المتحدة الأمريكية', 'iso' => 'US'],
            ['name' => 'المملكة المتحدة', 'iso' => 'GB'],
            // Remaining countries
            ['name' => 'أفغانستان', 'iso' => 'AF'],
            ['name' => 'ألبانيا', 'iso' => 'AL'],
            ['name' => 'الجزائر', 'iso' => 'DZ'],
            ['name' => 'الأرجنتين', 'iso' => 'AR'],
            ['name' => 'أستراليا', 'iso' => 'AU'],
            ['name' => 'النمسا', 'iso' => 'AT'],
            ['name' => 'البحرين', 'iso' => 'BH'],
            ['name' => 'بنغلاديش', 'iso' => 'BD'],
            ['name' => 'بلجيكا', 'iso' => 'BE'],
            ['name' => 'البرازيل', 'iso' => 'BR'],
            ['name' => 'كندا', 'iso' => 'CA'],
            ['name' => 'الصين', 'iso' => 'CN'],
            ['name' => 'الدنمارك', 'iso' => 'DK'],
            ['name' => 'فرنسا', 'iso' => 'FR'],
            ['name' => 'ألمانيا', 'iso' => 'DE'],
            ['name' => 'الهند', 'iso' => 'IN'],
            ['name' => 'إندونيسيا', 'iso' => 'ID'],
            ['name' => 'إيران', 'iso' => 'IR'],
            ['name' => 'العراق', 'iso' => 'IQ'],
            ['name' => 'إيطاليا', 'iso' => 'IT'],
            ['name' => 'اليابان', 'iso' => 'JP'],
            ['name' => 'الكويت', 'iso' => 'KW'],
            ['name' => 'ماليزيا', 'iso' => 'MY'],
            ['name' => 'المغرب', 'iso' => 'MA'],
            ['name' => 'هولندا', 'iso' => 'NL'],
            ['name' => 'النرويج', 'iso' => 'NO'],
            ['name' => 'عُمان', 'iso' => 'OM'],
            ['name' => 'باكستان', 'iso' => 'PK'],
            ['name' => 'فلسطين', 'iso' => 'PS'],
            ['name' => 'قطر', 'iso' => 'QA'],
            ['name' => 'سنغافورة', 'iso' => 'SG'],
            ['name' => 'كوريا الجنوبية', 'iso' => 'KR'],
            ['name' => 'إسبانيا', 'iso' => 'ES'],
            ['name' => 'السويد', 'iso' => 'SE'],
            ['name' => 'سويسرا', 'iso' => 'CH'],
            ['name' => 'سوريا', 'iso' => 'SY'],
            ['name' => 'الإمارات العربية المتحدة', 'iso' => 'AE'],
            ['name' => 'اليمن', 'iso' => 'YE'],
        ];

        foreach ($countries as $country) {
            Country::firstOrCreate(['iso' => $country['iso']], $country);
        }
    }
}
