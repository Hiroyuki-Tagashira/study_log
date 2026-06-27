<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //バックエンド
        \App\Models\Subject::create([
            'field_id' => 1,
            'name' => "Java",
        ]);
        \App\Models\Subject::create([
            'field_id' => 1,
            'name' => "PHP",
        ]);
        \App\Models\Subject::create([
            'field_id' => 1,
            'name' => "Ruby",
        ]);
        \App\Models\Subject::create([
            'field_id' => 1,
            'name' => "Python",
        ]);
        //フロントエンド
        \App\Models\Subject::create([
            'field_id' => 2,
            'name' => "HTML&CSS",
        ]);
        \App\Models\Subject::create([
            'field_id' => 2,
            'name' => "JavaScript",
        ]);
        \App\Models\Subject::create([
            'field_id' => 2,
            'name' => "TypeScript",
        ]);
        //その他
        \App\Models\Subject::create([
            'field_id' => 3,
            'name' => "SQL",
        ]);
        \App\Models\Subject::create([
            'field_id' => 3,
            'name' => "基本情報技術者試験",
        ]);
        \App\Models\Subject::create([
            'field_id' => 3,
            'name' => "ITパスポート試験",
        ]);
        \App\Models\Subject::create([
            'field_id' => 3,
            'name' => "C言語",
        ]);
    }
}
