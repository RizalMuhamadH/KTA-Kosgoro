<?php

namespace Database\Seeders;

use App\Models\Feature;
use Illuminate\Database\Seeder;

class FeaturesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Feature::create([
            'slug' => 'events',
            'name' => 'Events'
        ]);

        Feature::create([
            'slug'  =>  'news',
            'name'  =>  'News'
        ]);
    }
}
