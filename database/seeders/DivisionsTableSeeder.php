<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DivisionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('divisions')->delete();

        DB::table('divisions')->insert(array (
            0 =>
                array (
                    'id' => 1,
                    'code' => 'BX',
                    'name' => 'Tổ bốc xếp',
                    'department_id' => 7,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            1 =>
                array (
                    'id' => 2,
                    'code' => 'MI',
                    'name' => 'Tổ Mixer',
                    'department_id' => 7,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            2 =>
                array (
                    'id' => 3,
                    'code' => 'AD',
                    'name' => 'Bộ phận Admin',
                    'department_id' => 8,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            3 =>
                array (
                    'id' => 4,
                    'code' => 'BV',
                    'name' => 'Ban bảo vệ',
                    'department_id' => 9,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            4 =>
                array (
                    'id' => 5,
                    'code' => 'PTN',
                    'name' => 'Phòng phân tích',
                    'department_id' => 11,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            5 =>
                array (
                    'id' => 6,
                    'code' => 'KTTT',
                    'name' => 'Kỹ thuật thị trường',
                    'department_id' => 8,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            6 =>
                array (
                    'id' => 7,
                    'code' => 'GSGC',
                    'name' => 'KD gia súc gia cầm',
                    'department_id' => 8,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            7 =>
                array (
                    'id' => 8,
                    'code' => 'KTT',
                    'name' => 'Kỹ thuật trại',
                    'department_id' => 8,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            8 =>
                array (
                    'id' => 9,
                    'code' => 'TS',
                    'name' => 'KD thủy sản',
                    'department_id' => 8,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            9 =>
                array (
                    'id' => 10,
                    'code' => 'TTY',
                    'name' => 'Thuốc thú y',
                    'department_id' => 8,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            10 =>
                array (
                    'id' => 11,
                    'code' => 'SXGSGC',
                    'name' => 'SX gia súc gia cầm',
                    'department_id' => 6,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            11 =>
                array (
                    'id' => 12,
                    'code' => 'SXTS',
                    'name' => 'SX thủy sản',
                    'department_id' => 6,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            12 =>
                array (
                    'id' => 13,
                    'code' => 'BH',
                    'name' => 'Tổ bán hàng',
                    'department_id' => 4,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            13 =>
                array (
                    'id' => 14,
                    'code' => 'CAN',
                    'name' => 'Tổ cân',
                    'department_id' => 4,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            14 =>
                array (
                    'id' => 15,
                    'code' => 'TV',
                    'name' => 'Tổ tạp vụ',
                    'department_id' => 9,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            15 =>
                array (
                    'id' => 16,
                    'code' => 'NA',
                    'name' => 'Tổ nấu ăn',
                    'department_id' => 9,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            16 =>
                array (
                    'id' => 17,
                    'code' => 'NL',
                    'name' => 'Tổ nguyên liệu',
                    'department_id' => 7,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            18 =>
                array (
                    'id' => 19,
                    'code' => 'TR',
                    'name' => 'Tổ trồng rau',
                    'department_id' => 9,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            19 =>
                array (
                    'id' => 20,
                    'code' => 'KCSNL',
                    'name' => 'Tổ KCS nguyên liệu',
                    'department_id' => 11,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            20 =>
                array (
                    'id' => 21,
                    'code' => 'KCSTPTS',
                    'name' => 'Tổ KCS thành phẩm thủy sản',
                    'department_id' => 11,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            21 =>
                array (
                    'id' => 22,
                    'code' => 'KCSTPGS',
                    'name' => 'Tổ KCS thành phẩm gia súc',
                    'department_id' => 11,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            22 =>
                array (
                    'id' => 23,
                    'code' => 'BTC',
                    'name' => 'Ban tài chính',
                    'department_id' => 4,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            23 =>
                array (
                    'id' => 24,
                    'code' => 'IT',
                    'name' => 'Bộ phận IT',
                    'department_id' => 2,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            24 =>
                array (
                    'id' => 25,
                    'code' => 'NKS',
                    'name' => 'Tổ kiểm soát',
                    'department_id' => 2,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
        ));
    }
}
