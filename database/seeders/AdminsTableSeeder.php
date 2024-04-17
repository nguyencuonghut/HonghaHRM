<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('admins')->delete();

        DB::table('admins')->insert(array (
            0 =>
                array (
                    'id' => 1,
                    'name' => 'Tony Nguyen',
                    'email' => 'nguyenvancuong@honghafeed.com.vn',
                    'password' => bcrypt('Hongha@123'),
                    'role_id' => 1,
                    'remember_token' => null,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            1 =>
                array (
                    'id' => 2,
                    'name' => 'Trần Thị Bích Phương',
                    'email' => 'tranthibichphuong@honghafeed.com.vn',
                    'password' => bcrypt('Hongha@123'),
                    'role_id' => 4,
                    'remember_token' => null,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            2 =>
                array (
                    'id' => 3,
                    'name' => 'Phạm Thị Thơm',
                    'email' => 'ns@honghafeed.com.vn',
                    'password' => bcrypt('Hongha@123'),
                    'role_id' => 4,
                    'remember_token' => null,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            3 =>
                array (
                    'id' => 4,
                    'name' => 'Nguyễn Thị Ngọc Lan',
                    'email' => 'nguyenthingoclan@honghafeed.com.vn',
                    'password' => bcrypt('Hongha@123'),
                    'role_id' => 4,
                    'remember_token' => null,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            4 =>
                array (
                    'id' => 5,
                    'name' => 'Tạ Văn Toại',
                    'email' => 'gd@honghafeed.com.vn',
                    'password' => bcrypt('Hongha@123'),
                    'role_id' => 2,
                    'remember_token' => null,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            5 =>
                array (
                    'id' => 6,
                    'name' => 'Hoàng Thị Ngọc Ánh',
                    'email' => 'tdv@honghafeed.com.vn',
                    'password' => bcrypt('Hongha@123'),
                    'role_id' => 3,
                    'remember_token' => null,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            6 =>
                array (
                    'id' => 7,
                    'name' => 'Triệu Thị Hương',
                    'email' => 'trieuthihuong@honghafeed.com.vn',
                    'password' => bcrypt('Hongha@123'),
                    'role_id' => 3,
                    'remember_token' => null,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            7 =>
                array (
                    'id' => 8,
                    'name' => 'Lưu Văn Tuấn',
                    'email' => 'luuvantuan@honghafeed.com.vn',
                    'password' => bcrypt('Hongha@123'),
                    'role_id' => 3,
                    'remember_token' => null,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            8 =>
                array (
                    'id' => 9,
                    'name' => 'Nguyễn Văn Long',
                    'email' => 'nguyenvanlong@honghafeed.com.vn',
                    'password' => bcrypt('Hongha@123'),
                    'role_id' => 3,
                    'remember_token' => null,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            9 =>
                array (
                    'id' => 10,
                    'name' => 'Trần Tiến Dũng',
                    'email' => 'trantiendung@honghafeed.com.vn',
                    'password' => bcrypt('Hongha@123'),
                    'role_id' => 3,
                    'remember_token' => null,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
        ));
    }
}
