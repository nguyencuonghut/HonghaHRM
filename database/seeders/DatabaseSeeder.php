<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            DepartmentsTableSeeder::class,
            DivisionsTableSeeder::class,
            RolesTableSeeder::class,
            AdminsTableSeeder::class,
            UsersTableSeeder::class,
            UserDepartmentTableSeeder::class,
            AdminDepartmentTableSeeder::class,
            UserDivisionTableSeeder::class,
            PositionsTableSeeder::class,
            UserPositionTableSeeder::class,
            ProvincesTableSeeder::class,
            DistrictsTableSeeder::class,
            CommunesTableSeeder::class,
            CompanyJobsTableSeeder::class,
            RecruitmentMethodsTableSeeder::class,
            RecruitmentSocialMediaTableSeeder::class,
            CvReceiveMethodsTableSeeder::class,
            SchoolsTableSeeder::class,
            DegreesTableSeeder::class,
            DocumentsTableSeeder::class,
            EmployeesTableSeeder::class,
            EmployeeSchoolsTableSeeder::class,
            OnTypesTableSeeder::class,
            OffTypesTableSeeder::class,
            EmployeeWorksTableSeeder::class,
            IncreaseDecreaseInsurancesTableSeeder::class,
            DepartmentManagersTableSeeder::class,
            DivisionManagersTableSeeder::class,
            ContractTypesTableSeeder::class,
            EmployeeContractsTableSeeder::class,
            InsurancesTableSeeder::class,
            RegimesTableSeeder::class,
            WelfaresTableSeeder::class,
        ]);
    }
}
