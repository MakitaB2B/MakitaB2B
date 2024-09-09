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
use App\Http\Controllers\Admin\ReservedStockController;
use App\Http\Controllers\Admin\ReplacedPartsController;
use App\Http\Controllers\Admin\RolesPermissionController;
use App\Http\Controllers\Admin\TeamController;
use App\Http\Controllers\Admin\FactoryServiceStationController;
use App\Http\Controllers\Admin\DailySalesController;
use App\Http\Controllers\Admin\ToolsService;
use App\Http\Controllers\Admin\PendingPoController;
use App\Http\Controllers\Admin\AssetMasterController;
use App\Http\Controllers\Admin\EmployeeLeaveApplicationController;
use App\Http\Controllers\Admin\PromotionController;
use App\Http\Controllers\Admin\DealerController;
use App\Http\Controllers\Admin\ItemInfoController;
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
Route::get('/cxtoolsrepaircostestimation/{tsSlug}',[WarrantyController::class,'cxConfirmRejectToolsRepairCostEstimation'])->name('cxtoolsrepaircostestimation');
Route::post('/accept-reject-cost-estimation-cx-wl',[WarrantyController::class,'acceptRejectTRCostEstimationWithoutLogin'])->name('accept-reject-cost-estimation-cx-wl');


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
Route::post('/cx-tsr-registration',[ToolsService::class,'createOrUpdateToolsService'])->name('cx-tsr-registration');
Route::get('/cx-tools-repair-list',[WarrantyController::class,'listofToolsRepair'])->name('cx-tools-repair-list');
Route::post('/accept-reject-cost-estimation-cx',[WarrantyController::class,'acceptRejectTRCostEstimation'])->name('accept-reject-cost-estimation-cx');
});
/*-----End Front Route-----*/

/*-----Start Admin Route-----*/
Route::get('admin/login',[AdminLoginController::class,'index'])->name('adminlogin');
Route::post('admin/auth',[AdminLoginController::class,'auth'])->name('admin.auth');
Route::get('admin/register',[AdminLoginController::class,'register'])->name('adminregister');
Route::post('admin/checkregister',[AdminLoginController::class,'checkRegisterByPhone'])->name('admin.checkregister');
Route::post('admin/empfpotpv',[AdminLoginController::class,'verifyEmpPwrdOtpControler'])->name('admin.empfpotpv');
Route::get('admin/checkotp/{empSlug}',[AdminLoginController::class,'otpView'])->name('checkotp');
Route::get('admin/empresetpassword/{empSlug}',[AdminLoginController::class,'resetPasswordView'])->name('empresetpassword');
Route::post('admin/empresetpass',[AdminLoginController::class,'empResetCreatePassword'])->name('admin.empresetpass');
// Route::get('admin/direct-logout',[AdminLoginController::class,'logout'])->name('admin.logout');

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
    Route::get('/productmodel/manage-product-model/{productmodelslug?}',[ProductModelController::class,'manageProductModelSlug'])->name('productmodel.manage-product-model');
    Route::post('/productmodel/manage-product-model-process',[ProductModelController::class,'manageProductModelProcess'])->name('productmodel.manage-product-model-process');
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
    Route::post('/upload-daily-stock',[BranchStockController::class,'uploadDailyStocks'])->name('upload-daily-stock');
    Route::get('/holidays',[HolidayController::class,'index']);
    Route::get('/holidays/manage-holiday/{id?}',[HolidayController::class,'manageHoliday'])->name('holidays.manage-holiday');
    Route::post('/holidays/manage-holiday-process',[HolidayController::class,'createOrUpdateHolidayController'])->name('holidays.manage-holiday-process');
    Route::get('/reserved-stock',[ReservedStockController::class,'index'])->name('reserved-stock');
    Route::post('/upload-reserved-stock',[ReservedStockController::class,'uploadReservedStocks'])->name('upload-reserved-stock');
    Route::post('/reserve-stock-search',[ReservedStockController::class,'searchReservedStock'])->name('reserve-stock-search');
    Route::post('/reserve-stock-filterguardian',[ReservedStockController::class,'reservedStockFilterGuardian'])->name('reserve-stock-filterguardian');
    Route::post('/reserve-stock-filerresult',[ReservedStockController::class,'filterReservedStock'])->name('reserve-stock-filerresult');
    Route::get('/reserve-stock-fetchby-item/{item}',[ReservedStockController::class,'fetchReserveStockByItem'])->name('reserve-stock-fetchby-item');
    Route::get('/replaced-parts',[ReplacedPartsController::class,'index'])->name('replaced-parts');
    Route::post('/upload-replaced-parts',[ReplacedPartsController::class,'uploadReplacedParts'])->name('upload-replaced-parts');
    Route::post('/replaced-parts-search',[ReplacedPartsController::class,'searchReplacedParts'])->name('replaced-parts-search');
    Route::post('/replaced-parts-filterguardian',[ReplacedPartsController::class,'replacedPartsFilterGuardian'])->name('replaced-parts-filterguardian');
    Route::post('/replaced-parts-filerresult',[ReplacedPartsController::class,'filterReplacedParts'])->name('replaced-parts-filerresult');
    Route::get('/pending-po',[PendingPoController::class,'index'])->name('pending-po');
    Route::post('/upload-pending-po',[PendingPoController::class,'uploadPendingPO'])->name('upload-pending-po');
    Route::post('/pending-po-search',[PendingPoController::class,'searchPendingPO'])->name('pending-po-search');

    Route::get('/roles',[RolesPermissionController::class,'roleIndex'])->name('roles');
    Route::get('/roles/manage-role/{roleslug?}',[RolesPermissionController::class,'manageRole'])->name('roles.manage-role');
    Route::post('/roles/manage-role-process',[RolesPermissionController::class,'manageRoleProcess'])->name('roles.manage-role-process');
    Route::get('/permission',[RolesPermissionController::class,'permissionIndex'])->name('permission');
    Route::get('/permission/manage-permission/{permissionslug?}',[RolesPermissionController::class,'managePermission'])->name('permission.manage-permission');
    Route::post('/permission/manage-permission-process',[RolesPermissionController::class,'managePermissionProcess'])->name('permission.manage-permission-process');
    Route::get('/access-modules',[RolesPermissionController::class,'accessModuleIndex'])->name('access-modules');
    Route::get('/access-modules/manage-modules/{moduleslug?}',[RolesPermissionController::class,'manageAccessModule'])->name('access-modules.manage-modules');
    Route::post('/access-modules/manage-modules-process',[RolesPermissionController::class,'manageAccessModuleProcess'])->name('access-modules.manage-modules-process');
    Route::get('/teams',[TeamController::class,'index']);
    Route::post('/teams/manage-team-process',[TeamController::class,'createOrUpdateTeams'])->name('teams.manage-team-process');
    Route::get('/teams/manage-team-members/{teamslug}',[TeamController::class,'manageTeamMember'])->name('teams.manage-team-members');
    Route::post('/teams/manage-team-member-process',[TeamController::class,'manageTeamMemberProcess'])->name('teams.manage-team-member-process');
    Route::get('/service-management',[ToolsService::class,'index'])->name('service-management');
    Route::get('/service-management/manage-service-requiest/{srSlug?}',[ToolsService::class,'manageServiceRequest'])->name('service-management.manage-service-requiest');
    Route::post('/service-management/manage-service-requiest-process',[ToolsService::class,'createOrUpdateToolsService'])->name('service-management.manage-service-requiest-process');
    Route::post('/service-management/send-service-cost-estimation-cx',[ToolsService::class,'createOrUpdateServiceCostEstimation'])->name('service-management.send-service-cost-estimation-cx');
    Route::post('/service-management/send-repair-completion-sms',[ToolsService::class,'sendRepairCompletionSMS'])->name('service-management.send-repair-completion-sms');
    Route::post('/service-management/submit-tools-handover-data',[ToolsService::class,'insertToolstHandOverData'])->name('service-management.submit-tools-handover-data');
    Route::post('/service-management/close-sr',[ToolsService::class,'closeSR'])->name('service-management.close-sr');
    Route::post('/service-management/reason-over-48-hours',[ToolsService::class,'reasonOver48Hours'])->name('service-management.reason-over-48-hours');
    Route::post('/service-management/export-asm-report-exel',[ToolsService::class,'aSMReportExportExcel'])->name('service-management.export-asm-report-exel');
    Route::get('/factory-service-center',[FactoryServiceStationController::class,'index']);
    Route::get('/fsc/manage-fsc/{fscslug?}',[FactoryServiceStationController::class,'manageFSC'])->name('fsc.manage-manage-fsc');
    Route::post('/fsc/manage-fsc-process',[FactoryServiceStationController::class,'manageFSCProcess'])->name('fsc.manage-fsc-process');
    Route::get('/fsc/assignee-fsc-executive/{fscSlug}',[FactoryServiceStationController::class,'manageFSCServiceExecutive']);
    Route::post('/fsc/manage-fsc-executive-process',[FactoryServiceStationController::class,'manageFSCServiceExecutiveProcess'])->name('fsc.manage-fsc-executive-process');
    Route::get('/daily-sales',[DailySalesController::class,'index'])->name('daily-sales');
    Route::post('/upload-daily-sales-report',[DailySalesController::class,'uploadDailySalesReport'])->name('upload-daily-sales-report');
    Route::get('/asset-master',[AssetMasterController::class,'index'])->name('asset-master');
    Route::get('/asset-master/manage-asset-master/{assetMasterSlug?}',[AssetMasterController::class,'manageAssetMaster'])->name('admin.asset-master.manage-asset-master');
    Route::post('/asset-master/manage-asset-master-process',[AssetMasterController::class,'createOrUpdateAssetMaster'])->name('asset-master.manage-asset-master-process');
    Route::post('/asset-master/check-assettag-existence',[AssetMasterController::class,'checkAssetTagExistance']);
    Route::post('/asset-master/msofficelicence-existence',[AssetMasterController::class,'checkMSOfficeLicenceExistance']);
    Route::post('/asset-master/operatingsystemserialnumber-existence',[AssetMasterController::class,'operatingSystemSerialNumberExistance']);

    Route::get('/employee/leave-application',[EmployeeLeaveApplicationController::class,'index'])->name('employee.leave-application');
    Route::get('/employee/manage-leave-application/{empLvApSlug?}',[EmployeeLeaveApplicationController::class,'manageLeaveApllication'])->name('employee.manage-leave-appllication');
    Route::post('/employee/manage-leave-application-process',[EmployeeLeaveApplicationController::class,'createOrUpdateLeaveApllication'])->name('employee.manage-leave-appllication-process');
    Route::post('/employee/change-leave-applications-status',[EmployeeLeaveApplicationController::class,'changeLeaveApplicationStatus'])->name('employee.change-leave-applications-status');

    Route::get('/travelmanagement/applyviewclaimtravelexpenses',function(){
        return view('Admin/business_travel_list');
    })->name('travelmanagement.applyviewclaimtravelexpenses');

    Route::get('/promotions',[PromotionController::class,'index'])->name('promo');
    Route::get('/promotions/promotion-creation',[PromotionController::class,'promotionCreation'])->name('admin.promotions.promotion-creation');
    Route::post('/promotions/promotion-create',[PromotionController::class,'promotionCreate'])->name('admin.promotions.promotion-create');
    Route::get('/promotions/promotion-preview/{promocode}',[PromotionController::class,'promotionPreview'])->name('admin.promotions.promotion-preview');
    Route::get('/promotions/promotion-transaction',[PromotionController::class,'promotionTransaction'])->name('admin.promotions.transaction');
    Route::get('/promotions/transaction-creation',[PromotionController::class,'transactionCreation'])->name('admin.promotions.promotion-transaction');
    Route::post('/promotions/transaction-create',[PromotionController::class,'transactionCreate'])->name('admin.promotions.transaction-create');
    Route::get('/promotions/transaction-preview/{orderid}',[PromotionController::class,'transactionPreview'])->name('promotions.transaction-preview');
    Route::get('/promotions/promotion-fetch',[PromotionController::class,'getPromo'])->name('admin.promotions.promotion-fetch');
    Route::get('/promotions/search-data', [PromotionController::class, 'searchData'])->name('search.data');
    Route::get('/promotions/model-details-search', [PromotionController::class, 'modeldetailSearch'])->name('model.detail.Search');
    Route::get('/promotions/single-model-details-search', [PromotionController::class, 'modeldetailSingleSearch'])->name('model.single.detail.Search');
    Route::get('/promotions/transaction-verify',[PromotionController::class,'transactionVerify'])->name('admin.promotions.transaction-verify');
    Route::post('/promotions/promotion-changestatus', [PromotionController::class, 'changeStatus'])->name('promotions.change-status');
    Route::post('/promotions/transaction-changestatus', [PromotionController::class, 'changeTransationStatus'])->name('transaction.change-status');
    Route::get('/items', [ItemInfoController::class, 'index'])->name('items');
    Route::post('/items-search',[ItemInfoController::class,'itemSearch'])->name('item-search');
    Route::post('/upload-daily-item',[ItemInfoController::class,'uploadDailyItem'])->name('upload-daily-item');
    Route::get('/dealers', [DealerController::class, 'index'])->name('dealers');
    Route::post('/dealer-search',[DealerController::class,'dealerSearch'])->name('item-search');
    Route::post('/upload-dealer',[DealerController::class,'uploadDealer'])->name('upload-dealer');

    // Route::get('/send-promo-email', function(){
    //     $details['email'] = 'lobojeanz@gmail.com';
    //     dispatch(new App\Jobs\PromoJob($details));
    //     return response()->json(['message'=>'Mail Send Successfully!!']);
    // });

    // Route::get('/promotions/promomailview/{promocode}',  function () {  return view('mails.promomail');  });
    Route::get('/promotions/transactionmailview',  function () {  return view('mails.transactionmail');  });

    Route::get('/promotions/promomail/{promocode}', [PromotionController::class, 'promomail']);
    Route::get('/promotions/transactionmail/{transactioncode}', [PromotionController::class, 'transactionmail']);

    Route::get('/roi', function () {  return view('Admin/roi');  });

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
