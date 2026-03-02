<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
       
        DB::table('accounts')->insert([
            [
                'username' => 'admin',
                'password' => Hash::make('admin123'),
                'email' => 'admin@musicstore.com',
                'role' => 'admin',
                'first_name' => 'Store',
                'last_name' => 'Admin',
                'profile_photo_url' => 'images/profiles/admin.jpg',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'customer1',
                'password' => Hash::make('password123'),
                'email' => 'customer1@email.com',
                'role' => 'customer',
                'first_name' => 'Juan',
                'last_name' => 'Dela Cruz',
                'profile_photo_url' => 'images/profiles/customer1.jpg',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

       
        DB::table('positions')->insert([
            ['position_name' => 'Store Manager', 'monthly_rate' => 35000, 'created_at'=>now(),'updated_at'=>now()],
            ['position_name' => 'Sales Staff', 'monthly_rate' => 18000, 'created_at'=>now(),'updated_at'=>now()],
        ]);

      
        DB::table('employees')->insert([
            [
                'first_name' => 'Maria',
                'last_name' => 'Santos',
                'email' => 'maria@musicstore.com',
                'employment_status' => 'active',
                'hire_date' => Carbon::now()->subYears(2),
                'current_position_id' => 1,
                'created_at'=>now(),'updated_at'=>now()
            ],
            [
                'first_name' => 'Pedro',
                'last_name' => 'Reyes',
                'email' => 'pedro@musicstore.com',
                'employment_status' => 'active',
                'hire_date' => Carbon::now()->subYear(),
                'current_position_id' => 2,
                'created_at'=>now(),'updated_at'=>now()
            ],
        ]);

        
        DB::table('categories')->insert([
            [
                'category_name' => 'Pianos',
                'description' => 'Acoustic and digital pianos',
                'photo_url' => 'images/categories/piano.jpg',
                'created_at'=>now(),'updated_at'=>now()
            ],
            [
                'category_name' => 'Guitars',
                'description' => 'Acoustic and electric guitars',
                'photo_url' => 'images/categories/guitar.jpg',
                'created_at'=>now(),'updated_at'=>now()
            ],
        ]);

        
        DB::table('brands')->insert([
            ['brand_name'=>'Yamaha','logo_url'=>'images/brands/yamaha.png','website'=>'https://yamaha.com','created_at'=>now(),'updated_at'=>now()],
            ['brand_name'=>'Fender','logo_url'=>'images/brands/fender.png','website'=>'https://fender.com','created_at'=>now(),'updated_at'=>now()],
            ['brand_name'=>'Gibson','logo_url'=>'images/brands/gibson.png','website'=>'https://gibson.com','created_at'=>now(),'updated_at'=>now()],
            ['brand_name'=>'Kawai','logo_url'=>'images/brands/kawai.png','website'=>'https://kawai-global.com','created_at'=>now(),'updated_at'=>now()],
        ]);

       
        DB::table('products')->insert([
            [
                'product_name'=>'Yamaha U3 Acoustic Piano',
                'brand_id'=>1,
                'category_id'=>1,
                'retail_price'=>450000,
                'cost_price'=>380000,
                'stock_level'=>5,
                'description'=>'A very expensive piano (does it have a MIDI tho?).',
                'created_at'=>now(),'updated_at'=>now()
            ],
            [
                'product_name'=>'Kawai KDP120 Piano',
                'brand_id'=>4,
                'category_id'=>1,
                'retail_price'=>75000,
                'cost_price'=>60000,
                'stock_level'=>8,
                'description'=>'A very expensive piano.',
                'created_at'=>now(),'updated_at'=>now()
            ],
            [
                'product_name'=>'Fender Stratocaster',
                'brand_id'=>2,
                'category_id'=>2,
                'retail_price'=>55000,
                'cost_price'=>42000,
                'stock_level'=>10,
                'description'=>'The guitar I saw from 10 Things I Hate About You.',
                'created_at'=>now(),'updated_at'=>now()
            ],
            [
                'product_name'=>'Gibson Les Paul Standard',
                'brand_id'=>3,
                'category_id'=>2,
                'retail_price'=>145000,
                'cost_price'=>120000,
                'stock_level'=>4,
                'description'=>'A very expensive guitar.',
                'created_at'=>now(),'updated_at'=>now()
            ],
        ]);

        
        DB::table('product_photos')->insert([
            ['product_id'=>1,'photo_url'=>'images/products/yamaha_u3.jpg','is_primary'=>true,'created_at'=>now(),'updated_at'=>now()],
            ['product_id'=>2,'photo_url'=>'images/products/kawai_kdp120.jpg','is_primary'=>true,'created_at'=>now(),'updated_at'=>now()],
            ['product_id'=>3,'photo_url'=>'images/products/fender_strat.jpg','is_primary'=>true,'created_at'=>now(),'updated_at'=>now()],
            ['product_id'=>4,'photo_url'=>'images/products/gibson_lespaul.jpg','is_primary'=>true,'created_at'=>now(),'updated_at'=>now()],
        ]);

        
        DB::table('orders')->insert([
            [
                'user_id'=>2,
                'payment_status'=>'paid',
                'order_status'=>'completed',
                'payment_option'=>'GCash',
                'delivery_fee'=>1500,
                'completed_at'=>now(),
                'created_at'=>now(),
                'updated_at'=>now(),
            ]
        ]);

        DB::table('product_order')->insert([
            [
                'order_id'=>1,
                'product_id'=>3,
                'quantity'=>1,
                'unit_price'=>55000,
                'created_at'=>now(),
                'updated_at'=>now(),
            ]
        ]);

        DB::table('product_review')->insert([
            [
                'product_order_id'=>1,
                'user_id'=>2,
                'rating'=>5,
                'review_title'=>'Amazing Guitar!',
                'review_text'=>'Very smooth playability and excellent tone.',
                'is_verified'=>true,
                'created_at'=>now(),
                'updated_at'=>now(),
            ]
        ]);
    }
}


/*

public/
 └── images/
      ├── categories/
      │     ├── piano.jpg
      │     └── guitar.jpg
      ├── brands/
      │     ├── yamaha.png
      │     ├── fender.png
      │     ├── gibson.png
      │     └── kawai.png
      └── products/
            ├── yamaha_u3.jpg
            ├── kawai_kdp120.jpg
            ├── fender_strat.jpg
            └── gibson_lespaul.jpg

            */