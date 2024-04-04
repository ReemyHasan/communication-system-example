<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Service::insert([
            ['name' => '070', 'created_at'=>now(), 'updated_at'=>now()],
            ['name' => '999', 'created_at'=>now(), 'updated_at'=>now()],
            ['name' => '1111', 'created_at'=>now(), 'updated_at'=>now()],
            ['name' => '606', 'created_at'=>now(), 'updated_at'=>now()],
            ['name' => '666', 'created_at'=>now() , 'updated_at'=>now()],
        ]);
    }
}
