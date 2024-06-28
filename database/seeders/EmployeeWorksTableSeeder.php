<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class EmployeeWorksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        DB::table('employee_works')->delete();

        DB::table('employee_works')->insert(array (
            0 =>
                array (
                    'id' => 1,
                    'employee_id' => 1,
                    'company_job_id' => 69,
                    'status' => 'On',
                    'start_date' => '2014-01-01',
                    'end_date' => null,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            1 =>
                array (
                    'id' => 2,
                    'employee_id' => 1,
                    'company_job_id' => 19,
                    'status' => 'On',
                    'start_date' => '2019-01-01',
                    'end_date' => null,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            2 =>
                array (
                    'id' => 3,
                    'employee_id' => 2,
                    'company_job_id' => 40,
                    'status' => 'On',
                    'start_date' => '2016-09-12',
                    'end_date' => null,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            3 =>
                array (
                    'id' => 4,
                    'employee_id' => 3,
                    'company_job_id' => 41,
                    'status' => 'Off',
                    'start_date' => '2020-01-01',
                    'end_date' => '2022-01-01',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            4 =>
                array (
                    'id' => 5,
                    'employee_id' => 3,
                    'company_job_id' => 39,
                    'status' => 'On',
                    'start_date' => '2022-01-01',
                    'end_date' => null,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            5 =>
                array (
                    'id' => 6,
                    'employee_id' => 4,
                    'company_job_id' => 63,
                    'status' => 'Off',
                    'start_date' => '2021-01-01',
                    'end_date' => '2024-01-01',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            6 =>
                array (
                    'id' => 7,
                    'employee_id' => 4,
                    'company_job_id' => 78,
                    'status' => 'On',
                    'start_date' => '2024-01-01',
                    'end_date' => null,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            7 =>
                array (
                    'id' => 8,
                    'employee_id' => 5,
                    'company_job_id' => 63,
                    'status' => 'On',
                    'start_date' => '2022-01-01',
                    'end_date' => null,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            8 =>
                array (
                    'id' => 9,
                    'employee_id' => 6,
                    'company_job_id' => 79,
                    'status' => 'On',
                    'start_date' => '2015-01-01',
                    'end_date' => null,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            9 =>
                array (
                    'id' => 10,
                    'employee_id' => 6,
                    'company_job_id' => 20,
                    'status' => 'On',
                    'start_date' => '2019-01-01',
                    'end_date' => null,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            10 =>
                array (
                    'id' => 11,
                    'employee_id' => 7,
                    'company_job_id' => 42,
                    'status' => 'Off',
                    'start_date' => '2012-01-01',
                    'end_date' => '2023-01-01',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            11 =>
                array (
                    'id' => 12,
                    'employee_id' => 7,
                    'company_job_id' => 80,
                    'status' => 'On',
                    'start_date' => '2023-01-01',
                    'end_date' => null,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            12 =>
                array (
                    'id' => 13,
                    'employee_id' => 8,
                    'company_job_id' => 66,
                    'status' => 'On',
                    'start_date' => '2023-01-01',
                    'end_date' => null,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            13 =>
                array (
                    'id' => 14,
                    'employee_id' => 9,
                    'company_job_id' => 66,
                    'status' => 'On',
                    'start_date' => '2011-01-01',
                    'end_date' => null,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            14 =>
                array (
                    'id' => 15,
                    'employee_id' => 10,
                    'company_job_id' => 66,
                    'status' => 'Off',
                    'start_date' => '2011-01-01',
                    'end_date' => '2020-01-01',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            15 =>
                array (
                    'id' => 16,
                    'employee_id' => 10,
                    'company_job_id' => 82,
                    'status' => 'Off',
                    'start_date' => '2020-01-01',
                    'end_date' => '2022-01-01',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            16 =>
                array (
                    'id' => 17,
                    'employee_id' => 10,
                    'company_job_id' => 83,
                    'status' => 'On',
                    'start_date' => '2022-01-01',
                    'end_date' => null,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            17 =>
                array (
                    'id' => 18,
                    'employee_id' => 10,
                    'company_job_id' => 81,
                    'status' => 'On',
                    'start_date' => '2024-01-01',
                    'end_date' => null,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            18 =>
                array (
                    'id' => 19,
                    'employee_id' => 11,
                    'company_job_id' => 68,
                    'status' => 'On',
                    'start_date' => '2011-01-01',
                    'end_date' => null,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            19 =>
                array (
                    'id' => 20,
                    'employee_id' => 12,
                    'company_job_id' => 68,
                    'status' => 'On',
                    'start_date' => '2011-01-01',
                    'end_date' => null,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            20 =>
                array (
                    'id' => 21,
                    'employee_id' => 13,
                    'company_job_id' => 43,
                    'status' => 'Off',
                    'start_date' => '2011-01-01',
                    'end_date' => '2020-01-01',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            21 =>
                array (
                    'id' => 22,
                    'employee_id' => 13,
                    'company_job_id' => 84,
                    'status' => 'On',
                    'start_date' => '2019-01-01',
                    'end_date' => null,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            22 =>
                array (
                    'id' => 23,
                    'employee_id' => 14,
                    'company_job_id' => 43,
                    'status' => 'On',
                    'start_date' => '2011-01-01',
                    'end_date' => null,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            23 =>
                array (
                    'id' => 24,
                    'employee_id' => 15,
                    'company_job_id' => 43,
                    'status' => 'On',
                    'start_date' => '2022-01-01',
                    'end_date' => null,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            24 =>
                array (
                    'id' => 25,
                    'employee_id' => 15,
                    'company_job_id' => 68,
                    'status' => 'Off',
                    'start_date' => '2013-01-01',
                    'end_date' => '2022-01-01',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            25 =>
                array (
                    'id' => 26,
                    'employee_id' => 16,
                    'company_job_id' => 84,
                    'status' => 'Off',
                    'start_date' => '2016-01-01',
                    'end_date' => '2022-01-01',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            26 =>
                array (
                    'id' => 27,
                    'employee_id' => 16,
                    'company_job_id' => 77,
                    'status' => 'On',
                    'start_date' => '2023-01-01',
                    'end_date' => null,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            27 =>
                array (
                    'id' => 28,
                    'employee_id' => 17,
                    'company_job_id' => 13,
                    'status' => 'On',
                    'start_date' => '2015-01-01',
                    'end_date' => null,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            28 =>
                array (
                    'id' => 29,
                    'employee_id' => 18,
                    'company_job_id' => 15,
                    'status' => 'On',
                    'start_date' => '2003-01-01',
                    'end_date' => null,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            29 =>
                array (
                    'id' => 30,
                    'employee_id' => 19,
                    'company_job_id' => 57,
                    'status' => 'Off',
                    'start_date' => '2015-01-01',
                    'end_date' => '2020-01-01',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            30 =>
                array (
                    'id' => 31,
                    'employee_id' => 19,
                    'company_job_id' => 71,
                    'status' => 'On',
                    'start_date' => '2020-01-01',
                    'end_date' => null,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            31 =>
                array (
                    'id' => 32,
                    'employee_id' => 20,
                    'company_job_id' => 72,
                    'status' => 'On',
                    'start_date' => '2015-01-01',
                    'end_date' => null,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            32 =>
                array (
                    'id' => 33,
                    'employee_id' => 21,
                    'company_job_id' => 17,
                    'status' => 'On',
                    'start_date' => '2018-01-01',
                    'end_date' => null,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            33 =>
                array (
                    'id' => 34,
                    'employee_id' => 22,
                    'company_job_id' => 21,
                    'status' => 'On',
                    'start_date' => '2019-01-01',
                    'end_date' => null,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            34 =>
                array (
                    'id' => 35,
                    'employee_id' => 23,
                    'company_job_id' => 75,
                    'status' => 'On',
                    'start_date' => '2022-01-01',
                    'end_date' => null,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            35 =>
                array (
                    'id' => 36,
                    'employee_id' => 23,
                    'company_job_id' => 63,
                    'status' => 'Off',
                    'start_date' => '2015-01-01',
                    'end_date' => '2022-01-01',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
        ));
    }
}
