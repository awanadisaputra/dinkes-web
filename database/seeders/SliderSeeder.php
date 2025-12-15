<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SliderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sliders = [
            [
                'image' => 'https://images.unsplash.com/photo-1557821552-17105176677c?w=1200&h=600&fit=crop',
                'title' => 'Welcome to Our Website',
                'caption' => 'Discover amazing products and services that will transform your business',
                'urutan' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'image' => 'https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=1200&h=600&fit=crop',
                'title' => 'Innovation at Its Best',
                'caption' => 'We provide cutting-edge solutions for modern challenges',
                'urutan' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'image' => 'https://images.unsplash.com/photo-1551434678-e076c223a692?w=1200&h=600&fit=crop',
                'title' => 'Your Success is Our Priority',
                'caption' => 'Join thousands of satisfied customers worldwide',
                'urutan' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'image' => 'https://images.unsplash.com/photo-1542744173-8e7e53415bb0?w=1200&h=600&fit=crop',
                'title' => 'Quality You Can Trust',
                'caption' => 'Experience premium quality products with excellent service',
                'urutan' => 4,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'image' => 'https://images.unsplash.com/photo-1504384308090-c894fdcc538d?w=1200&h=600&fit=crop',
                'title' => 'Start Your Journey Today',
                'caption' => 'Take the first step towards achieving your goals with us',
                'urutan' => 5,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        DB::table('sliders')->insert($sliders);
    }
}