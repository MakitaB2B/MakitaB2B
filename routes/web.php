<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\AdminLoginController;
use App\Http\Controllers\Admin\ProductCategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\DesignationController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\CityController;
use App\Http\Controllers\Admin\EmployeeStiffDocsController;
use App\Http\Controllers\Admin\EmployeeWorkExperienceController;
use App\Http\Controllers\Admin\StateController;
use App\Http\Controllers\Admin\LocationController;
use App\Http\Controllers\Admin\ProductModelController;
use App\Http\Controllers\Admin\BranchStockController;
use App\Http\Controllers\Admin\HolidayController;

use App\Http\Controllers\Front\WarrantyController;
use App\Http\Controllers\Front\CustomerLoginRegistrationController;

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

Route::get('/', function () {
    return view('welcome');
});
/*-----Start Front Route-----*/
Route::get('/cx-login',[CustomerLoginRegistrationController::class,'cxLoginView'])->name('cxlogin');
Route::get('/cx-signup/{cxslug?}/{flag?}',[CustomerLoginRegistrationController::class,'customerSignup'])->name('customer-signup');
Route::post('/cx-signup-otp-send',[CustomerLoginRegistrationController::class,'customerSignupSigninOTPSend'])->name('cx-signup-otp-send');
Route::post('/cx-signup-resend-otp',[CustomerLoginRegistrationController::class,'customerSignupSigninResendOTP'])->name('cx-signup-resend-otp');
Route::get('/cx-signup-otp-page/{cxslug}/{flag?}',[CustomerLoginRegistrationController::class,'customerOTPPage'])->name('cx-signup-otp-page');
Route::get('/cx-login-password-making/{cxslug}/{flag?}',[CustomerLoginRegistrationController::class,'createCXLoginPasswordView'])->name('cx-login-password-making');
Route::post('/cx-login-password-dbinsert/{cxslug?}',[CustomerLoginRegistrationController::class,'createCXLoginPassword'])->name('cx-login-password-dbinsert');
Route::post('/cx-login-credentials-process',[CustomerLoginRegistrationController::class,'cxLoginProcess'])->name('cx-login-credentials-process');
Route::post('/cx-otp-verification',[CustomerLoginRegistrationController::class,'verifyCXLoginRegisOTP']);
Route::get('/cx-forget-password',[CustomerLoginRegistrationController::class,'cxForgetPasswordView'])->name('cx-forget-password');
Route::post('/cx-login-password-reset',[CustomerLoginRegistrationController::class,'resetCXLoginPassword'])->name('cx-login-password-reset');


Route::group(['middleware' => ['customer']], function() {
Route::get('/cx-signup-details',[CustomerLoginRegistrationController::class,'customerSignupPersonalDetails'])->name('cx-signup-details');
Route::get('/warranty-registration/{modelID?}/{slno?}',[WarrantyController::class,'warrantyCard'])->name('warranty-card');
Route::post('/warranty-registration-process',[WarrantyController::class,'warrantyCardProcess'])->name('warranty-registration-process');
Route::get('/cx-warranty-registration-fairmsg',[WarrantyController::class,'warrantyRegistrationUtterMsg'])->name('cx-warranty-registration-fairmsg');
Route::post('/cx-profile-manage',[CustomerLoginRegistrationController::class,'manageCustomerProfileProcess'])->name('cx-profile-manage');
Route::post('/city/get-cities-by-state',[CustomerLoginRegistrationController::class,'prepCitiesByStates']);
Route::get('/warranty-scan-machine',[WarrantyController::class,'scanningMachineBcode'])->name('warranty-scan-machine');
Route::post('/prod-model-details',[WarrantyController::class,'getProductSpecificModelDetails']);
Route::post('/check-serialnumber-existence',[WarrantyController::class,'checkSerialNumberExistence'])->name('check-serialnumber-existence');
Route::get('/warranty-registration-list-spec-cx',[WarrantyController::class,'getWarrantyListForSpecCX'])->name('warranty-registration-list-spec-cx');
Route::get('/cx-logout',[CustomerLoginRegistrationController::class,'logout'])->name('customerlogout');
});
/*-----End Front Route-----*/

/*-----Start Admin Route-----*/
Route::get('admin/login',[AdminLoginController::class,'index'])->name('adminlogin');
Route::post('admin/auth',[AdminLoginController::class,'auth'])->name('admin.auth');
Route::group(['prefix' => 'admin','middleware' => ['admin']], function() {
    Route::get('/dashboard',[AdminLoginController::class,'dashboard'])->name('admin.dashboard');
    Route::get('/admins',[AdminLoginController::class,'adminList'])->name('admin.admins');
    Route::get('/admins/manage-admin/{adminSlug?}',[AdminLoginController::class,'manageAdmin'])->name('admin.admins.manage-admin');
    Route::post('/admins/manage-admin-process',[AdminLoginController::class,'manageAdminProcess'])->name('admins.manage-admin-process');
    Route::get('/logout',[AdminLoginController::class,'logout'])->name('admin.logout');
    Route::get('/productcategory',[ProductCategoryController::class,'index'])->name('admin.productcategory');
    Route::get('/productcategory/manage-productcategory/{prodcateslug?}',[ProductCategoryController::class,'manageProductCategory'])->name('productcategory.manage-productcategory');
    Route::post('/productcategory/manage-productcategory-process',[ProductCategoryController::class,'manageProductCategoryProcess'])->name('productcategory.manage-productcategory-process');
    Route::get('/product',[ProductController::class,'index'])->name('admin.product');
    Route::get('/product/manage-product/{productslug?}',[ProductController::class,'manageProduct'])->name('productcategory.manage-product');
    Route::post('/product/manage-product-process',[ProductController::class,'manageProductProcess'])->name('product.manage-product-process');
    Route::get('/productmodel',[ProductModelController::class,'index'])->name('admin.productmodel');
    Route::get('/department',[DepartmentController::class,'index'])->name('admin.department');
    Route::get('/department/manage-department/{departmentslug?}',[DepartmentController::class,'manageDepartment'])->name('department.manage-department');
    Route::post('/department/manage-department-process',[DepartmentController::class,'manageDepartmentProcess'])->name('department.manage-department-process');
    Route::get('/designation',[DesignationController::class,'index'])->name('admin.designation');
    Route::get('/designation/manage-designation/{designationslug?}',[DesignationController::class,'manageDesignation'])->name('designation.manage-designation');
    Route::post('/designation/manage-designation-process',[DesignationController::class,'manageDesignationProcess'])->name('designation.manage-designation-process');
    Route::post('/designation/get-designations-by-department',[DesignationController::class,'prepareDesignationsByDepertmant']);
    Route::get('/employee',[EmployeeController::class,'index'])->name('admin.employee');
    Route::get('/employee/manage-employee/{employeeslug?}',[EmployeeController::class,'manageEmployee'])->name('employee.manage-employee');
    Route::post('/employee/manage-employee-process',[EmployeeController::class,'manageEmployeeProcess'])->name('employee.manage-employee-process');
    Route::get('/employee/manage-employee-stiffdoc/{employeeslug?}',[EmployeeStiffDocsController::class,'manageEmployeeStiffDocs'])->name('employee.manage-employee-stiffdoc');
    Route::post('/employee/manage-employee-stiffdoc-process',[EmployeeStiffDocsController::class,'manageEmployeeStiffDocsProcess'])->name('employee.manage-employee-stiffdoc-process');
    Route::get('/employee/manage-employee-workexp/{employeeslug?}',[EmployeeWorkExperienceController::class,'manageEmployeeWorkExprience'])->name('employee.manage-employee-workexp');
    Route::post('/employee/manage-employee-workexp-process',[EmployeeWorkExperienceController::class,'manageEmployeeWorkExprienceProcess'])->name('employee.manage-employee-workexp-process');
    Route::get('/employee/employee-work-exp-delete/{eweSlug}',[EmployeeWorkExperienceController::class,'employeeWorkExprienceDelete']);
    Route::get('/state',[StateController::class,'index'])->name('admin.state');
    Route::get('/state/manage-state/{stateSlug?}',[StateController::class,'manageState'])->name('admin.state.manage-state');
    Route::post('/state/manage-state-process',[StateController::class,'manageStateProcess'])->name('state.manage-state-process');
    Route::get('/city',[CityController::class,'index'])->name('admin.city');
    Route::post('/city/get-cities-by-state',[CityController::class,'prepareCitiesByStates']);
    Route::get('/city/manage-city/{citySlug?}',[CityController::class,'manageCity'])->name('admin.city.manage-city');
    Route::post('/city/manage-city-process',[CityController::class,'manageCityProcess'])->name('city.manage-city-process');
    Route::get('/location',[LocationController::class,'index'])->name('admin.location');
    Route::get('/location/manage-location/{locationSlug?}',[LocationController::class,'manageLocation'])->name('admin.location.manage-location');
    Route::post('/location/manage-location-process',[LocationController::class,'manageLopcationProcess'])->name('location.manage-location-process');
    Route::get('/warranty-applications',[WarrantyController::class,'getAllWarrantyApplications'])->name('admin.warranty-applications');
    Route::post('/warranty/change-warranty-applications-status',[WarrantyController::class,'changeWarrantyApplicationStatus'])->name('warranty.change-warranty-applications-status');
    Route::get('/warranty/manage-warranty-application/{warrantySlug?}',[WarrantyController::class,'manageWarrantyApplication'])->name('warranty.manage-warranty-application');
    Route::get('/branch-stock',[BranchStockController::class,'index'])->name('branch-stock');
    Route::get('/branch-stock-details/{mvid}',[BranchStockController::class,'getBranchStockDetails'])->name('branch-stock-details');
    Route::post('/stock-search',[BranchStockController::class,'searchStock'])->name('stock-search');
    Route::post('/update-stock',[BranchStockController::class,'updateBranchStock'])->name('update-stock');
    Route::get('/holidays',[HolidayController::class,'index']);
    Route::get('/holidays/manage-holiday/{id?}',[HolidayController::class,'manageHoliday'])->name('holidays.manage-holiday');
    Route::post('/holidays/manage-holiday-process',[HolidayController::class,'createOrUpdateHolidayController'])->name('holidays.manage-holiday-process');

});

/*-----End Admin Route-----*/


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
