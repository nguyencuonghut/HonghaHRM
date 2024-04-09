<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->delete();

        DB::table('users')->insert(array (
            0 =>
                array (
                    'id' => 1,
                    'name' => 'Phạm Hồng Hải',
                    'email' => 'phamhonghai@honghafeed.com.vn',
                    'password' => bcrypt('Hongha@123'),
                    'img_path' => 'dist/img/1.jpeg',
                    'email_verified_at' => null,
                    'remember_token' => null,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            1 =>
                array (
                    'id' => 2,
                    'name' => 'Nguyễn Xuân Trường',
                    'email' => 'nguyenxuantruong@honghafeed.com.vn',
                    'password' => bcrypt('Hongha@123'),
                    'img_path' => 'dist/img/2.jpeg',
                    'email_verified_at' => null,
                    'remember_token' => null,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
            ),
            2 =>
                array (
                    'id' => 3,
                    'name' => 'Nguyễn Tiến Dũng',
                    'email' => 'nguyentiendung@honghafeed.com.vn',
                    'password' => bcrypt('Hongha@123'),
                    'img_path' => 'dist/img/3.jpeg',
                    'email_verified_at' => null,
                    'remember_token' => null,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            3 =>
                array (
                    'id' => 4,
                    'name' => 'Nguyễn Văn Cường',
                    'email' => 'nguyenvancuong@honghafeed.com.vn',
                    'password' => bcrypt('Hongha@123'),
                    'img_path' => 'dist/img/4.jpeg',
                    'email_verified_at' => null,
                    'remember_token' => null,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            4 =>
                array (
                    'id' => 5,
                    'name' => 'Bùi Thị Nụ',
                    'email' => 'buithinu@honghafeed.com.vn',
                    'password' => bcrypt('Hongha@123'),
                    'img_path' => 'dist/img/5.jpeg',
                    'email_verified_at' => null,
                    'remember_token' => null,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            5 =>
                array (
                    'id' => 6,
                    'name' => 'Tạ Văn Toại',
                    'email' => 'tavantoai@honghafeed.com.vn',
                    'password' => bcrypt('Hongha@123'),
                    'img_path' => 'dist/img/6.jpeg',
                    'email_verified_at' => null,
                    'remember_token' => null,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            6 =>
                array (
                    'id' => 7,
                    'name' => 'Phạm Thị Trang',
                    'email' => 'phamthitrang@honghafeed.com.vn',
                    'password' => bcrypt('Hongha@123'),
                    'img_path' => 'dist/img/7.jpeg',
                    'email_verified_at' => null,
                    'remember_token' => null,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            7 =>
                array (
                    'id' => 8,
                    'name' => 'Lê Thị Hồng',
                    'email' => 'lethihong@honghafeed.com.vn',
                    'password' => bcrypt('Hongha@123'),
                    'img_path' => 'dist/img/8.jpeg',
                    'email_verified_at' => null,
                    'remember_token' => null,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            8 =>
                array (
                    'id' => 9,
                    'name' => 'Hoàng Thị Ngọc Ánh',
                    'email' => 'hoangthingocanh@honghafeed.com.vn',
                    'password' => bcrypt('Hongha@123'),
                    'img_path' => 'dist/img/9.jpeg',
                    'email_verified_at' => null,
                    'remember_token' => null,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            9 =>
                array (
                    'id' => 10,
                    'name' => 'Phạm Thị Thơm',
                    'email' => 'phamthithom@honghafeed.com.vn',
                    'password' => bcrypt('Hongha@123'),
                    'img_path' => 'dist/img/10.jpeg',
                    'email_verified_at' => null,
                    'remember_token' => null,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            10 =>
                array (
                    'id' => 11,
                    'name' => 'Trần Thị Bích Phương',
                    'email' => 'tranthibichphuong@honghafeed.com.vn',
                    'password' => bcrypt('Hongha@123'),
                    'img_path' => 'dist/img/11.jpeg',
                    'email_verified_at' => null,
                    'remember_token' => null,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            11 =>
                array (
                    'id' => 12,
                    'name' => 'Nguyễn Thị Ngọc Lan',
                    'email' => 'nguyenthingoclan@honghafeed.com.vn',
                    'password' => bcrypt('Hongha@123'),
                    'img_path' => 'dist/img/12.jpeg',
                    'email_verified_at' => null,
                    'remember_token' => null,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            12 =>
                array (
                    'id' => 13,
                    'name' => 'Nguyễn Thị Ánh',
                    'email' => 'nguyenthianh@honghafeed.com.vn',
                    'password' => bcrypt('Hongha@123'),
                    'img_path' => 'dist/img/13.jpeg',
                    'email_verified_at' => null,
                    'remember_token' => null,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
        ));
    }
}
