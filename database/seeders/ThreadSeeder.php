<?php

namespace Database\Seeders;

use App\Models\Thread;
use Illuminate\Database\Seeder;

class ThreadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Thread::factory()->count(5)->create(['author_id' => 2]);
        Thread::factory()->count(5)->create(['author_id' => 3]);
    }
}
