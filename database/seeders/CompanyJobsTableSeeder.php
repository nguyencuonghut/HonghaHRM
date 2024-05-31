<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CompanyJobsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('company_jobs')->delete();

        DB::table('company_jobs')->insert(array (
            0 =>
                array (
                    'id' => 1,
                    'name' => 'Nhân viên lái xe',
                    'department_id' => 9,
                    'division_id' => null,
                    'position_salary' => 6000000,
                    'max_capacity_salary' => 3000000,
                    'position_allowance' => 1000000,
                    'recruitment_standard_file' => 'dist/recruitment_standard/nv_lai_xe.pdf',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            1 =>
                array (
                    'id' => 2,
                    'name' => 'Nhân viên nấu ăn',
                    'department_id' => 9,
                    'division_id' => null,
                    'position_salary' => 5000000,
                    'max_capacity_salary' => 2000000,
                    'position_allowance' => 1500000,
                    'recruitment_standard_file' => 'dist/recruitment_standard/nv_nau_an.pdf',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            2 =>
                array (
                    'id' => 3,
                    'name' => 'Nhân viên bảo vệ',
                    'department_id' => 9,
                    'division_id' => 4,
                    'position_salary' => 6000000,
                    'max_capacity_salary' => 4000000,
                    'position_allowance' => 2000000,
                    'recruitment_standard_file' => 'dist/recruitment_standard/nv_bao_ve.pdf',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            3 =>
                array (
                    'id' => 4,
                    'name' => 'Công nhân kỹ thuật trại',
                    'department_id' => 8,
                    'division_id' => null,
                    'position_salary' => 4000000,
                    'max_capacity_salary' => 4000000,
                    'position_allowance' => 3000000,
                    'recruitment_standard_file' => 'dist/recruitment_standard/cn_ktt.pdf',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            4 =>
                array (
                    'id' => 5,
                    'name' => 'Nhân viên kỹ thuật thị trường',
                    'department_id' => 8,
                    'division_id' => 6,
                    'position_salary' => 7000000,
                    'max_capacity_salary' => 5000000,
                    'position_allowance' => 4000000,
                    'recruitment_standard_file' => 'dist/recruitment_standard/nv_kttt.pdf',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            5 =>
                array (
                    'id' => 6,
                    'name' => 'Nhân viên kinh doanh',
                    'department_id' => 8,
                    'division_id' => 7,
                    'position_salary' => 8000000,
                    'max_capacity_salary' => 6000000,
                    'position_allowance' => 5000000,
                    'recruitment_standard_file' => 'dist/recruitment_standard/nv_kd.pdf',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            6 =>
                array (
                    'id' => 7,
                    'name' => 'Nhân viên kỹ thuật trại',
                    'department_id' => 8,
                    'division_id' => 8,
                    'position_salary' => 8500000,
                    'max_capacity_salary' => 5500000,
                    'position_allowance' => 45000000,
                    'recruitment_standard_file' => 'dist/recruitment_standard/nv_ktt.pdf',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            7 =>
                array (
                    'id' => 8,
                    'name' => 'Nhân viên kinh doanh',
                    'department_id' => 8,
                    'division_id' => 9,
                    'position_salary' => 9000000,
                    'max_capacity_salary' => 7000000,
                    'position_allowance' => 7000000,
                    'recruitment_standard_file' => 'dist/recruitment_standard/nv_ts.pdf',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            8 =>
                array (
                    'id' => 9,
                    'name' => 'Nhân viên kinh doanh',
                    'department_id' => 8,
                    'division_id' => 10,
                    'position_salary' => 9500000,
                    'max_capacity_salary' => 7500000,
                    'position_allowance' => 7500000,
                    'recruitment_standard_file' => 'dist/recruitment_standard/nv_tty.pdf',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
        ));
    }
}
