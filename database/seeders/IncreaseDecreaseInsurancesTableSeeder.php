<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class IncreaseDecreaseInsurancesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        DB::table('increase_decrease_insurances')->delete();

        DB::table('increase_decrease_insurances')->insert(array (
            0 =>
                array (
                    'id' => 1,
                    'employee_work_id' => 1,
                    'increase_confirmed_month' => '2014-01-01',
                    'is_increase' => true,
                    'is_decrease' => false,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            1 =>
                array (
                    'id' => 2,
                    'employee_work_id' => 3,
                    'increase_confirmed_month' => '2016-09-01',
                    'is_increase' => true,
                    'is_decrease' => false,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            2 =>
                array (
                    'id' => 3,
                    'employee_work_id' => 4,
                    'increase_confirmed_month' => '2020-02-01',
                    'is_increase' => true,
                    'is_decrease' => false,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            3 =>
                array (
                    'id' => 4,
                    'employee_work_id' => 6,
                    'increase_confirmed_month' => null,
                    'is_increase' => true,
                    'is_decrease' => false,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            4 =>
                array (
                    'id' => 5,
                    'employee_work_id' => 8,
                    'increase_confirmed_month' => null,
                    'is_increase' => true,
                    'is_decrease' => false,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            5 =>
                array (
                    'id' => 6,
                    'employee_work_id' => 9,
                    'increase_confirmed_month' => '2015-06-01',
                    'is_increase' => true,
                    'is_decrease' => false,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            6 =>
                array (
                    'id' => 7,
                    'employee_work_id' => 11,
                    'increase_confirmed_month' => '2012-08-01',
                    'is_increase' => true,
                    'is_decrease' => false,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            7 =>
                array (
                    'id' => 8,
                    'employee_work_id' => 13,
                    'increase_confirmed_month' => '2023-09-01',
                    'is_increase' => true,
                    'is_decrease' => false,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            8 =>
                array (
                    'id' => 9,
                    'employee_work_id' => 14,
                    'increase_confirmed_month' => '2011-10-01',
                    'is_increase' => true,
                    'is_decrease' => false,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            9 =>
                array (
                    'id' => 10,
                    'employee_work_id' => 15,
                    'increase_confirmed_month' => '2011-11-01',
                    'is_increase' => true,
                    'is_decrease' => false,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            10 =>
                array (
                    'id' => 11,
                    'employee_work_id' => 19,
                    'increase_confirmed_month' => '2011-04-01',
                    'is_increase' => true,
                    'is_decrease' => false,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            11 =>
                array (
                    'id' => 12,
                    'employee_work_id' => 20,
                    'increase_confirmed_month' => '2011-05-01',
                    'is_increase' => true,
                    'is_decrease' => false,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            12 =>
                array (
                    'id' => 13,
                    'employee_work_id' => 21,
                    'increase_confirmed_month' => '2011-06-01',
                    'is_increase' => true,
                    'is_decrease' => false,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            13 =>
                array (
                    'id' => 14,
                    'employee_work_id' => 23,
                    'increase_confirmed_month' => '2011-05-01',
                    'is_increase' => true,
                    'is_decrease' => false,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            14 =>
                array (
                    'id' => 15,
                    'employee_work_id' => 24,
                    'increase_confirmed_month' => '2013-06-01',
                    'is_increase' => true,
                    'is_decrease' => false,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            15 =>
                array (
                    'id' => 16,
                    'employee_work_id' => 26,
                    'increase_confirmed_month' => '2016-07-01',
                    'is_increase' => true,
                    'is_decrease' => false,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            16 =>
                array (
                    'id' => 17,
                    'employee_work_id' => 28,
                    'increase_confirmed_month' => '2015-08-01',
                    'is_increase' => true,
                    'is_decrease' => false,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            17 =>
                array (
                    'id' => 18,
                    'employee_work_id' => 29,
                    'increase_confirmed_month' => '2003-09-01',
                    'is_increase' => true,
                    'is_decrease' => false,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            18 =>
                array (
                    'id' => 19,
                    'employee_work_id' => 30,
                    'increase_confirmed_month' => '2015-10-01',
                    'is_increase' => true,
                    'is_decrease' => false,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            19 =>
                array (
                    'id' => 20,
                    'employee_work_id' => 32,
                    'increase_confirmed_month' => '2015-11-01',
                    'is_increase' => true,
                    'is_decrease' => false,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            20 =>
                array (
                    'id' => 21,
                    'employee_work_id' => 33,
                    'increase_confirmed_month' => '2018-12-01',
                    'is_increase' => true,
                    'is_decrease' => false,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            21 =>
                array (
                    'id' => 22,
                    'employee_work_id' => 34,
                    'increase_confirmed_month' => '2019-02-01',
                    'is_increase' => true,
                    'is_decrease' => false,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            22 =>
                array (
                    'id' => 23,
                    'employee_work_id' => 35,
                    'increase_confirmed_month' => '2022-03-01',
                    'is_increase' => true,
                    'is_decrease' => false,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            23 =>
                array (
                    'id' => 24,
                    'employee_work_id' => 37,
                    'increase_confirmed_month' => '2016-05-01',
                    'is_increase' => true,
                    'is_decrease' => false,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            24 =>
                array (
                    'id' => 25,
                    'employee_work_id' => 39,
                    'increase_confirmed_month' => '2024-03-01',
                    'is_increase' => true,
                    'is_decrease' => false,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
            25 =>
                array (
                    'id' => 26,
                    'employee_work_id' => 40,
                    'increase_confirmed_month' => '2013-06-01',
                    'is_increase' => true,
                    'is_decrease' => false,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ),
        ));
    }
}
