<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DistrictsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('districts')->delete();

        DB::table('districts')->insert(array (
            0 =>
                array (
                    'id' => 1,
                    'province_id' => 23,
                    'name' => 'Phủ Lý',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            1 =>
                array (
                    'id' => 2,
                    'province_id' => 23,
                    'name' => 'Duy Tiên',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            2 =>
                array (
                    'id' => 3,
                    'province_id' => 23,
                    'name' => 'Bình Lục',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            3 =>
                array (
                    'id' => 4,
                    'province_id' => 23,
                    'name' => 'Kim Bảng',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            4 =>
                array (
                    'id' => 5,
                    'province_id' => 23,
                    'name' => 'Thanh Liêm',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            5 =>
                array (
                    'id' => 6,
                    'province_id' => 23,
                    'name' => 'Lý Nhân',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            6 =>
                array (
                    'id' => 7,
                    'province_id' => 26,
                    'name' => 'Bình Giang',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            7 =>
                array (
                    'id' => 8,
                    'province_id' => 26,
                    'name' => 'Thanh Miện',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            8 =>
                array (
                    'id' => 9,
                    'province_id' => 26,
                    'name' => 'Cẩm Giàng',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            9 =>
                array (
                    'id' => 10,
                    'province_id' => 26,
                    'name' => 'thành phố Hải Dương',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            10 =>
                array (
                    'id' => 11,
                    'province_id' => 26,
                    'name' => 'Chí Linh',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            11 =>
                array (
                    'id' => 12,
                    'province_id' => 26,
                    'name' => 'Kinh Môn',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            12 =>
                array (
                    'id' => 13,
                    'province_id' => 26,
                    'name' => 'Gia Lộc',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            13 =>
                array (
                    'id' => 14,
                    'province_id' => 26,
                    'name' => 'Kim Thành',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            14 =>
                array (
                    'id' => 15,
                    'province_id' => 26,
                    'name' => 'Nam Sách',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            15 =>
                array (
                    'id' => 16,
                    'province_id' => 26,
                    'name' => 'Ninh Giang',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            16 =>
                array (
                    'id' => 17,
                    'province_id' => 26,
                    'name' => 'Tứ Kỳ',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            17 =>
                array (
                    'id' => 18,
                    'province_id' => 26,
                    'name' => 'Thanh Hà',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            18 =>
                array (
                    'id' => 19,
                    'province_id' => 31,
                    'name' => 'Thành phố Hưng Yên',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            19 =>
                array (
                    'id' => 20,
                    'province_id' => 31,
                    'name' => 'Mỹ Hào',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            20 =>
                array (
                    'id' => 21,
                    'province_id' => 31,
                    'name' => 'Ân Thi',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            21 =>
                array (
                    'id' => 22,
                    'province_id' => 31,
                    'name' => 'Khoái Châu',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            22 =>
                array (
                    'id' => 23,
                    'province_id' => 31,
                    'name' => 'Kim Động',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            23 =>
                array (
                    'id' => 24,
                    'province_id' => 31,
                    'name' => 'Phù Cừ',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            24 =>
                array (
                    'id' => 25,
                    'province_id' => 31,
                    'name' => 'Tiên Lữ',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            25 =>
                array (
                    'id' => 26,
                    'province_id' => 31,
                    'name' => 'Văn Giang',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            26 =>
                array (
                    'id' => 27,
                    'province_id' => 31,
                    'name' => 'Văn Lâm',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            27 =>
                array (
                    'id' => 28,
                    'province_id' => 31,
                    'name' => 'Yên Mỹ',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            28 =>
                array (
                    'id' => 29,
                    'province_id' => 24,
                    'name' => 'Ba Đình',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            29 =>
                array (
                    'id' => 30,
                    'province_id' => 24,
                    'name' => 'Hoàn Kiếm',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            30 =>
                array (
                    'id' => 31,
                    'province_id' => 24,
                    'name' => 'Tây Hồ',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            31 =>
                array (
                    'id' => 32,
                    'province_id' => 24,
                    'name' => 'Long Biên',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            32 =>
                array (
                    'id' => 33,
                    'province_id' => 24,
                    'name' => 'Cầu Giấy',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            33 =>
                array (
                    'id' => 34,
                    'province_id' => 24,
                    'name' => 'Đống Đa',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            34 =>
                array (
                    'id' => 35,
                    'province_id' => 24,
                    'name' => 'Hai Bà Trưng',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            35 =>
                array (
                    'id' => 36,
                    'province_id' => 24,
                    'name' => 'Hoàng Mai',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            36 =>
                array (
                    'id' => 37,
                    'province_id' => 24,
                    'name' => 'Thanh Xuân',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            37 =>
                array (
                    'id' => 38,
                    'province_id' => 24,
                    'name' => 'Hà Đông',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            38 =>
                array (
                    'id' => 39,
                    'province_id' => 24,
                    'name' => 'Bắc Từ Liêm',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            39 =>
                array (
                    'id' => 40,
                    'province_id' => 24,
                    'name' => 'Nam Từ Liêm',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            40 =>
                array (
                    'id' => 41,
                    'province_id' => 24,
                    'name' => 'Sơn Tây',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            41 =>
                array (
                    'id' => 42,
                    'province_id' => 24,
                    'name' => 'Ba Vì',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            42 =>
                array (
                    'id' => 43,
                    'province_id' => 24,
                    'name' => 'Chương Mỹ',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            43 =>
                array (
                    'id' => 44,
                    'province_id' => 24,
                    'name' => 'Đan Phượng',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            44 =>
                array (
                    'id' => 45,
                    'province_id' => 24,
                    'name' => 'Đông Anh',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            45 =>
                array (
                    'id' => 46,
                    'province_id' => 24,
                    'name' => 'Gia Lâm',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            46 =>
                array (
                    'id' => 47,
                    'province_id' => 24,
                    'name' => 'Hoài Đức',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            47 =>
                array (
                    'id' => 48,
                    'province_id' => 24,
                    'name' => 'Mê Linh',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            48 =>
                array (
                    'id' => 49,
                    'province_id' => 24,
                    'name' => 'Mỹ Đức',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            49 =>
                array (
                    'id' => 50,
                    'province_id' => 24,
                    'name' => 'Phú Xuyên',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            50 =>
                array (
                    'id' => 51,
                    'province_id' => 24,
                    'name' => 'Phúc Thọ',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            51 =>
                array (
                    'id' => 52,
                    'province_id' => 24,
                    'name' => 'Quốc Oai',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            52 =>
                array (
                    'id' => 53,
                    'province_id' => 24,
                    'name' => 'Sóc Sơn',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            53 =>
                array (
                    'id' => 54,
                    'province_id' => 24,
                    'name' => 'Thạch Thất',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            54 =>
                array (
                    'id' => 55,
                    'province_id' => 24,
                    'name' => 'Thanh Oai',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            55 =>
                array (
                    'id' => 56,
                    'province_id' => 24,
                    'name' => 'Thanh Trì',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            56 =>
                array (
                    'id' => 57,
                    'province_id' => 24,
                    'name' => 'Thường Tín',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            57 =>
                array (
                    'id' => 58,
                    'province_id' => 24,
                    'name' => 'Ứng Hòa',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
        ));
    }
}
