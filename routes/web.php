<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminHomeController;
use App\Http\Controllers\AdminLoginController;
use App\Http\Controllers\AdminRoleController;
use App\Http\Controllers\AdminAdminController;
use App\Http\Controllers\AdminDepartmentController;
use App\Http\Controllers\AdminDivisionController;
use App\Http\Controllers\AdminPositionController;
use App\Http\Controllers\AdminProvinceController;
use App\Http\Controllers\AdminDistrictController;
use App\Http\Controllers\AdminCommuneController;
use App\Http\Controllers\AdminSchoolController;
use App\Http\Controllers\AdminDegreeController;
use App\Http\Controllers\AdminCompanyJobController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AdminRecruitmentProposalController;
use App\Http\Controllers\AdminRecruitmentPlanController;
use App\Http\Controllers\AdminRecruitmentMethodController;
use App\Http\Controllers\AdminRecruitmentSocialMediaController;
use App\Http\Controllers\AdminCvReceiveMethodController;
use App\Http\Controllers\AdminRecruitmentAnnouncementController;
use App\Http\Controllers\AdminRecruitmentCandidateController;
use App\Http\Controllers\AdminProposalCandidateController;
use App\Http\Controllers\AdminProposalCandidateFilterController;
use App\Http\Controllers\AdminFirstInterviewInvitationController;
use App\Http\Controllers\AdminInitialInterviewController;
use App\Http\Controllers\AdminExaminationController;
use App\Http\Controllers\AdminFirstInterviewDetailController;
use App\Http\Controllers\AdminFirstInterviewResultController;
use App\Http\Controllers\AdminSecondInterviewInvitationController;
use App\Http\Controllers\AdminSecondInterviewDetailController;
use App\Http\Controllers\AdminSecondInterviewResultController;
use App\Http\Controllers\AdminOfferController;
use App\Http\Controllers\AdminCalendarController;
use App\Http\Controllers\AdminEmployeeController;
use App\Http\Controllers\AdminDocumentController;
use App\Http\Controllers\AdminEmployeeDocumentController;
use App\Http\Controllers\AdminEmployeeWorkController;
use App\Http\Controllers\AdminProbationController;
use App\Http\Controllers\AdminPlanController;
use App\Http\Controllers\AdminOrgController;
use App\Http\Controllers\AdminDepartmentManagerController;
use App\Http\Controllers\AdminDivisionManagerController;
use App\Http\Controllers\AdminEmployeeRelativeController;
use App\Http\Controllers\UserHomeController;
use App\Http\Controllers\UserLoginController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

/**
 * Admin routes
 */
Route::get('/admin/login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminLoginController::class, 'handleLogin'])->name('admin.handleLogin');
Route::get('/admin/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');

Route::get('/admin/forgot-password', [AdminLoginController::class, 'showForgotPasswordForm'])->name('admin.forgot.password.get');
Route::post('/admin/forgot-password', [AdminLoginController::class, 'submitForgotPasswordForm'])->name('admin.forgot.password.post');
Route::get('/admin/reset-password/{token}', [AdminLoginController::class, 'showResetPasswordForm'])->name('admin.reset.password.get');
Route::post('/admin/reset-password', [AdminLoginController::class, 'submitResetPasswordForm'])->name('admin.reset.password.post');

Route::name('admin.')->prefix('admin')->group(function() {
    Route::group(['middleware'=>'auth:admin'], function() {
        Route::get('/', [AdminHomeController::class, 'index'])->name('home');

        Route::get('departments/get-division/{department_id}', [AdminDepartmentController::class, 'getDivision'])->name('departments.getDivision');
        Route::get('departments/data', [AdminDepartmentController::class, 'anyData'])->name('departments.data');
        Route::resource('departments', AdminDepartmentController::class);

        Route::get('divisions/data', [AdminDivisionController::class, 'anyData'])->name('divisions.data');
        Route::resource('divisions', AdminDivisionController::class);

        Route::get('positions/data', [AdminPositionController::class, 'anyData'])->name('positions.data');
        Route::resource('positions', AdminPositionController::class);

        Route::get('provinces/data', [AdminProvinceController::class, 'anyData'])->name('provinces.data');
        Route::resource('provinces', AdminProvinceController::class);

        Route::get('districts/data', [AdminDistrictController::class, 'anyData'])->name('districts.data');
        Route::resource('districts', AdminDistrictController::class);

        Route::get('communes/data', [AdminCommuneController::class, 'anyData'])->name('communes.data');
        Route::resource('communes', AdminCommuneController::class);

        Route::resource('schools', AdminSchoolController::class);

        Route::resource('degrees', AdminDegreeController::class);

        Route::get('company_jobs/data', [AdminCompanyJobController::class, 'anyData'])->name('company_jobs.data');
        Route::resource('company_jobs', AdminCompanyJobController::class);

        Route::get('roles/data', [AdminRoleController::class, 'anyData'])->name('roles.data');
        Route::resource('roles', AdminRoleController::class);

        Route::get('admins/data', [AdminAdminController::class, 'anyData'])->name('admins.data');
        Route::resource('admins', AdminAdminController::class);

        Route::get('users/gallery', [AdminUserController::class, 'gallery'])->name('users.gallery');
        Route::get('users/data', [AdminUserController::class, 'anyData'])->name('users.data');
        Route::resource('users', AdminUserController::class);
        Route::post('users/import', [AdminUserController::class, 'import'])->name('users.import');

        Route::post('recruitment/proposals/approve/{proposal_id}', [AdminRecruitmentProposalController::class, 'approve'])->name('recruitment.proposals.approve');
        Route::post('recruitment/proposals/review/{proposal_id}', [AdminRecruitmentProposalController::class, 'review'])->name('recruitment.proposals.review');
        Route::get('recruitment/proposals/data', [AdminRecruitmentProposalController::class, 'anyData'])->name('recruitment.proposals.data');
        Route::resource('recruitment/proposals', AdminRecruitmentProposalController::class, ['names' => 'recruitment.proposals']);

        Route::post('recruitment/plans/approve/{proposal_id}', [AdminRecruitmentPlanController::class, 'approve'])->name('recruitment.plans.approve');
        Route::resource('recruitment/plans', AdminRecruitmentPlanController::class, ['names' => 'recruitment.plans']);

        Route::resource('recruitment/methods', AdminRecruitmentMethodController::class, ['names' => 'recruitment.methods']);

        Route::resource('recruitment/social_medias', AdminRecruitmentSocialMediaController::class, ['names' => 'recruitment.social_medias']);

        Route::resource('cv_receive_methods', AdminCvReceiveMethodController::class, ['names' => 'cv_receive_methods']);

        Route::resource('recruitment/announcements', AdminRecruitmentAnnouncementController::class, ['names' => 'recruitment.announcements']);

        Route::get('recruitment/candidates/data', [AdminRecruitmentCandidateController::class, 'anyData'])->name('recruitment.candidates.data');
        Route::resource('recruitment/candidates', AdminRecruitmentCandidateController::class, ['names' => 'recruitment.candidates']);

        Route::resource('recruitment/proposal_candidates', AdminProposalCandidateController::class, ['names' => 'recruitment.proposal_candidates']);

        Route::resource('recruitment/proposal_candidate_filter', AdminProposalCandidateFilterController::class, ['names' => 'recruitment.proposal_candidate_filter']);

        Route::get('recruitment/first_interview_invitation/add/{id}', [AdminFirstInterviewInvitationController::class, 'add'])->name('recruitment.first_interview_invitation.add');
        Route::get('recruitment/first_interview_invitation/feedback/{id}', [AdminFirstInterviewInvitationController::class, 'feedback'])->name('recruitment.first_interview_invitation.feedback');
        Route::resource('recruitment/first_interview_invitation', AdminFirstInterviewInvitationController::class, ['names' => 'recruitment.first_interview_invitation'], ['except' => 'create']);

        Route::resource('recruitment/initial_interview', AdminInitialInterviewController::class, ['names' => 'recruitment.initial_interview']);

        Route::resource('recruitment/exam', AdminExaminationController::class, ['names' => 'recruitment.exam']);

        Route::resource('recruitment/first_interview_detail', AdminFirstInterviewDetailController::class, ['names' => 'recruitment.first_interview_detail']);

        Route::resource('recruitment/first_interview_result', AdminFirstInterviewResultController::class, ['names' => 'recruitment.first_interview_result']);

        Route::get('recruitment/second_interview_invitation/add/{id}', [AdminSecondInterviewInvitationController::class, 'add'])->name('recruitment.second_interview_invitation.add');
        Route::get('recruitment/second_interview_invitation/feedback/{id}', [AdminSecondInterviewInvitationController::class, 'feedback'])->name('recruitment.second_interview_invitation.feedback');
        Route::resource('recruitment/second_interview_invitation', AdminSecondInterviewInvitationController::class, ['names' => 'recruitment.second_interview_invitation'], ['except' => 'create']);

        Route::resource('recruitment/second_interview_detail', AdminSecondInterviewDetailController::class, ['names' => 'recruitment.second_interview_detail']);

        Route::resource('recruitment/second_interview_result', AdminSecondInterviewResultController::class, ['names' => 'recruitment.second_interview_result']);

        Route::post('recruitment/offer/approve', [AdminOfferController::class, 'approve'])->name('recruitment.offer.approve');
        Route::resource('recruitment/offer', AdminOfferController::class, ['names' => 'recruitment.offer']);

        Route::get('calendars', [AdminCalendarController::class, 'index'])->name('calendars.index');

        Route::get('hr/employees/gallery', [AdminEmployeeController::class, 'gallery'])->name('hr.employees.gallery');
        Route::get('hr/employees/data', [AdminEmployeeController::class, 'anyData'])->name('hr.employees.data');
        Route::get('hr/employees/create_from_candidate/{proposal_candidate_id}', [AdminEmployeeController::class, 'createFromCandidate'])->name('hr.employees.create_from_candidate');
        Route::post('hr/employees/store_from_candidate', [AdminEmployeeController::class, 'storeFromCandidate'])->name('hr.employees.store_from_candidate');
        Route::resource('hr/employees', AdminEmployeeController::class, ['names' => 'hr.employees']);

        Route::post('hr/employees/document/makeSampleHdld/{employee_id}', [AdminEmployeeDocumentController::class, 'makeSampleHdld'])->name('hr.employees.document.makeSampleHdld');
        Route::post('hr/employees/document/makeSampleHdtv/{employee_id}', [AdminEmployeeDocumentController::class, 'makeSampleHdtv'])->name('hr.employees.document.makeSampleHdtv');
        Route::resource('hr/employees/document', AdminEmployeeDocumentController::class, ['names' => 'hr.employees.document']);

        Route::get('documents/data', [AdminDocumentController::class, 'anyData'])->name('documents.data');
        Route::resource('documents', AdminDocumentController::class);

        Route::resource('hr/employees/relative', AdminEmployeeRelativeController::class, ['names' => 'hr.employees.relative']);

        Route::get('hr/probations/data', [AdminProbationController::class, 'anyData'])->name('hr.probations.data');
        Route::post('hr/probations/approve/{id}', [AdminProbationController::class, 'approve'])->name('hr.probations.approve');
        Route::post('hr/probations/review/{id}', [AdminProbationController::class, 'review'])->name('hr.probations.review');
        Route::post('hr/probations/evaluate/{id}', [AdminProbationController::class, 'evaluate'])->name('hr.probations.evaluate');
        Route::resource('hr/probations', AdminProbationController::class, ['names' => 'hr.probations']);

        Route::get('hr/workings/data', [AdminEmployeeWorkController::class, 'anyData'])->name('hr.workings.data');
        Route::post('hr/workings/off/{id}', [AdminEmployeeWorkController::class, 'off'])->name('hr.workings.off');
        Route::get('hr/workings/off/{id}', [AdminEmployeeWorkController::class, 'getOff'])->name('hr.workings.getOff');
        Route::resource('hr/workings', AdminEmployeeWorkController::class, ['names' => 'hr.workings']);

        Route::get('hr/orgs/data', [AdminOrgController::class, 'anyData'])->name('hr.orgs.data');
        Route::get('hr/orgs/{department_id}', [AdminOrgController::class, 'show'])->name('hr.orgs.show');
        Route::get('hr/orgs', [AdminOrgController::class, 'index'])->name('hr.orgs.index');

        Route::resource('plans', AdminPlanController::class);

        Route::get('department_managers/data', [AdminDepartmentManagerController::class, 'anyData'])->name('department_managers.data');
        Route::resource('department_managers', AdminDepartmentManagerController::class);

        Route::get('division_managers/data', [AdminDivisionManagerController::class, 'anyData'])->name('division_managers.data');
        Route::resource('division_managers', AdminDivisionManagerController::class);
    });
});

/**
 * User routes
 */
Route::get('/login', [UserLoginController::class, 'showLoginForm'])->name('user.login');
Route::post('/login', [UserLoginController::class, 'handleLogin'])->name('user.handleLogin');
Route::get('/logout', [UserLoginController::class, 'logout'])->name('user.logout');

Route::group(['middleware'=>'auth:web'], function() {
    Route::get('/', [UserHomeController::class, 'index'])->name('user.home');
});
