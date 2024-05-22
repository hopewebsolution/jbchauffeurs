<?php

use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Http\Controllers\HomeController;
use App\Http\Controllers\HowItController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\AirportController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ContactUsController;
use App\Http\Controllers\OperatorRegistersController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\VehiclesController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\FixedRateController;
use App\Http\Controllers\FareController;
use App\Http\Controllers\SidebarBlocksController;
use App\Http\Controllers\BookWithUsControlloer;

/*Route::get('password/reset', [ForgotPasswordController::class,'showLinkRequestForm'])->name('user.forgetPwd');
Route::post('password/email', [ForgotPasswordController::class,'sendResetLinkEmail']);
Route::get('password/reset/{token}',[ResetPasswordController::class,'showResetForm']);
Route::post('password/reset',[ResetPasswordController::class,'reset']);*/
Route::group(['middleware' =>'countryCheck'],function(){
	$segment = Request::segment('1');
	if($segment){
		if(!in_array($segment,['aus','us','uk','nz'])){
			$segment="aus";
		}
	}
	Route::group(['prefix' => $segment], function(){
		Auth::routes();
		Route::get('password/reset', [ForgotPasswordController::class,'showLinkRequestForm'])->name('user.forgetPwd');
		Route::get('/',[HomeController::class,'home'])->name('user.home');
		Route::get('/about-us',[HomeController::class,'aboutUs'])->name('user.about');
		Route::get('/airport-transfers',[AirportController::class,'airportTrans'])->name('user.airportTrans');
		Route::get('/airport-details/{airport_id}/{url_slug?}',[AirportController::class,'airportTransDetails'])->name('user.airportTransDetails');
		Route::get('/how-it-works',[HowItController::class,'howItWorks'])->name('user.howItWorks');
		Route::get('/service-details/{service_id}/{slug?}',[ServiceController::class,'serviceDetails'])->name('user.serviceDetails');
		Route::get('/faq',[FaqController::class,'faqs'])->name('user.faq');
		Route::get('/contact-us',[ContactUsController::class,'contactUs'])->name('user.contactUs');
		Route::post('/send-contact-us',[ContactUsController::class,'webSendContactUs'])->name('user.webSendContactUs');
	    Route::post('/operator-registers',[OperatorRegistersController::class,'AddRegisters'])->name('user.makeOperatorRegisters');
		Route::post('/register', [OperatorRegistersController::class, 'AddRegisters'])->name('register.store');
		Route::get('/operator-registers',[OperatorRegistersController::class,'operatorRegisters'])->name('user.operatorRegisters');
		Route::get('/privacy-policy',[HomeController::class,'privacyPolicy'])->name('user.privacyPolicy');
		Route::get('/terms-conditions',[HomeController::class,'termsConditions'])->name('user.terms');
		Route::get('/page/{page_slug}',[HomeController::class,'cmsPage'])->name('user.cmsPage');
		Route::get('/customer-terms-conditions',[HomeController::class,'customerTerms'])->name('user.customerTerms');
		Route::get('/vehicles',[VehiclesController::class,'listVehicles'])->name('user.listVehicles');
		Route::post('/vehicles',[VehiclesController::class,'getVehicles'])->name('user.getVehicles');

		Route::post('/add-car-cart',[VehiclesController::class,'addCarToCart'])->name('user.addCarToCart');
		Route::get('/checkout',[CartController::class,'checkout'])->name('user.checkout');
		Route::post('/book-vehicle',[BookingController::class,'placeBooking'])->name('user.placeBooking');


		Route::group(['middleware' =>'guest:web'],function(){
		    /*Route::post('/password-email',[UserController::class,'pwdEmail'])->name('user.pwdEmail');
		    Route::get('/foregt-password',[UserController::class,'forgetPwdForm'])->name('user.forgetPwd');*/ 
		    
		    Route::post('/login-user',[UserController::class,'makeLogin'])->name('user.login');
		    Route::get('/login',[UserController::class,'userLoginForm'])->name('user.loginForm'); 
		    Route::get('/register',[UserController::class,'userSignupForm'])->name('user.signupForm'); 
		    Route::post('/signup-user',[UserController::class,'makeSignup'])->name('user.signup');
		});

		Route::group(['middleware' =>'auth:web'],function(){
			Route::get('/dashboard',[UserController::class,'dashboard'])->name('user.dashboard');
			Route::get('/logout',[UserController::class,'logout'])->name('user.logout');
			Route::get('/edit-profile',[UserController::class,'editProfile'])->name('user.editProfile');
			Route::post('/update-profile',[UserController::class,'updateProfile'])->name('user.updateProfile');
			Route::post('/update-password',[UserController::class,'updatePwd'])->name('user.updatePwd');
			Route::get('/change-password',[UserController::class,'changePwd'])->name('user.changePwd');
			Route::get('/bookings',[BookingController::class,'userBookings'])->name('user.bookings');
			Route::get('/booking-details/{booking_id}',[BookingController::class,'printBooking'])->name('user.printBooking');

			Route::get('handle-payment/{booking_id}',[BookingController::class,'createPayment'])->name('user.createPayment');
			Route::get('payment-success',[BookingController::class,'paymentSuccess'])->name('user.paymentSuccess');
			Route::get('cancel-transaction', [BookingController::class, 'cancelPayment'])->name('user.cancelPayment');
		});
	});
});


/*** Admin Routes Start ****/
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\SliderController;

Route::group(['prefix' =>'admin'],function(){
	$segment = Request::segment('2');
	if($segment){
		if(!in_array($segment,['aus','us','uk','nz'])){
			$segment="aus";
		}
	}else{
		$segment="aus";
	}
	Route::group(['middleware' =>'guest:admin'],function(){
	    Route::get('/', [AdminController::class,'loginAdmin']);
	    Route::get('/login',[AdminController::class,'loginAdmin'])->name('admin.login_form');
	    Route::get('/forget-password',[AdminController::class,'forgetPassword'])->name('admin.forgetPassword');
	    
	    Route::post('/admin-login', [AdminController::class,'makeLogin'])->name('admin.login');
	});
	Route::group(['prefix' =>$segment],function(){
	    Route::group(['middleware' =>'auth:admin'],function(){
	    	Route::get('/change-password',[AdminController::class,'adminChangePwd'])->name('admin.adminChangePwd');
	    	Route::post('/update-password', [AdminController::class,'updateAdminPwd'])->name('admin.updateAdminPwd');
			Route::get('/logout',[AdminController::class,'logout'])->name('admin.logout'); 
			Route::get('/dashboard',[AdminController::class,'dashboard'])->name("admin.dashboard");
			Route::get('/users',[UserController::class,'getUsers'])->name("admin.users");  
	    	Route::get('/users/search/{search_key?}',[UserController::class,'getUsers'])->name("admin.users.search");
	    	Route::post('/users/status',[UserController::class,'apiUpdateStatus'])->name("admin.users.status");
	    	Route::post('/users/delete',[UserController::class,'deleteUser'])->name("admin.users.delete");
	    	Route::get('/settings',[SettingController::class,'addSetting'])->name("admin.settings");  
	    	Route::post('/settings/create',[SettingController::class,'createSetting'])->name("admin.settings.create");

	    	Route::get('/sliders',[SliderController::class,'getAdminAllSliders'])->name("admin.sliders");
	    	Route::get('/sliders/search/{search_key?}',[SliderController::class,'getAdminAllSliders'])->name("admin.sliders.search");
	    	Route::get('/sliders/add',[SliderController::class,'addSlider'])->name("admin.sliders.add");  
	    	Route::get('/sliders/edit/{slide_id?}',[SliderController::class,'addSlider'])->name("admin.sliders.edit");  
		    Route::post('/sliders/create/{slide_id?}',[SliderController::class,'createSlider'])->name("admin.sliders.create");
		    Route::post('/sliders/delete',[SliderController::class,'deleteRow'])->name("admin.sliders.delete");

		    Route::get('/fixedRates',[FixedRateController::class,'getAdminAllfixedRates'])->name("admin.fixedRates");
	    	Route::get('/fixedRates/search/{search_key?}',[FixedRateController::class,'getAdminAllfixedRates'])->name("admin.fixedRates.search");
	    	Route::get('/fixedRates/add',[FixedRateController::class,'addfixedRate'])->name("admin.fixedRates.add");  
	    	Route::get('/fixedRates/edit/{id?}',[FixedRateController::class,'addfixedRate'])->name("admin.fixedRates.edit");  
		    Route::post('/fixedRates/create/{id?}',[FixedRateController::class,'createfixedRate'])->name("admin.fixedRates.create");
		    Route::post('/fixedRates/delete',[FixedRateController::class,'deleteFixedRate'])->name("admin.fixedRates.delete");

		    Route::get('/fares',[FareController::class,'getAdminAllfares'])->name("admin.fares");
	    	Route::get('/fares/add',[FareController::class,'addFare'])->name("admin.fares.add");  
	    	Route::get('/fares/edit/{id?}',[FareController::class,'addFare'])->name("admin.fares.edit");  
		    Route::post('/fares/create/{id?}',[FareController::class,'createFare'])->name("admin.fares.create");
		    Route::post('/fares/delete',[FareController::class,'deleteFare'])->name("admin.fares.delete");

		    Route::get('/services',[ServiceController::class,'getAdminAllServices'])->name("admin.services");
	    	Route::get('/services/search/{search_key?}',[ServiceController::class,'getAdminAllServices'])->name("admin.services.search");
	    	Route::get('/services/add',[ServiceController::class,'addService'])->name("admin.services.add");  
	    	Route::get('/services/edit/{service_id?}',[ServiceController::class,'addService'])->name("admin.services.edit");  
		    Route::post('/services/create/{service_id?}',[ServiceController::class,'createService'])->name("admin.services.create");
		    Route::post('/services/delete',[ServiceController::class,'deleteService'])->name("admin.services.delete");

		    Route::get('/vehicles',[VehiclesController::class,'getAdminAllVehicles'])->name("admin.vehicles");
	    	Route::get('/vehicles/search/{search_key?}',[VehiclesController::class,'getAdminAllVehicles'])->name("admin.vehicles.search");
	    	Route::get('/vehicles/add',[VehiclesController::class,'addVehicle'])->name("admin.vehicles.add");  
	    	Route::get('/vehicles/edit/{vehicle_id?}',[VehiclesController::class,'addVehicle'])->name("admin.vehicles.edit");  
		    Route::post('/vehicles/create/{vehicle_id?}',[VehiclesController::class,'createVehicle'])->name("admin.vehicles.create");
		    Route::post('/vehicles/delete',[VehiclesController::class,'deleteVehicle'])->name("admin.vehicles.delete");
		    
		    Route::get('/faqs',[FaqController::class,'getAdminAllFaqs'])->name("admin.faqs");
		    Route::get('/faqs/search/{search_key?}',[FaqController::class,'getAdminAllFaqs'])->name("admin.faqs.search");
		    Route::get('/faqs/add/{faq_id?}',[FaqController::class,'addFaq'])->name("admin.faqs.add");  
		    Route::get('/faqs/edit/{faq_id?}',[FaqController::class,'addFaq'])->name("admin.faqs.edit");  
		    Route::post('/faqs/create/{faq_id?}',[FaqController::class,'createFaq'])->name("admin.faqs.create");

		    Route::get('/bookings',[BookingController::class,'getAdminAllBookings'])->name("admin.bookings");
		    Route::get('/bookings/search/{search_key?}',[BookingController::class,'getAdminAllBookings'])->name("admin.bookings.search");  
		    Route::post('/bookings/update-booking',[BookingController::class,'apiUpdateBooking'])->name("admin.bookings.updateBooking");
		    Route::post('/bookings/delete',[BookingController::class,'bookingDelete'])->name("admin.bookings.delete");
		    Route::get('/booking-details/{booking_id}',[BookingController::class,'bookingDetails'])->name('admin.bookingDetails');

		    Route::get('/airports',[AirportController::class,'getAdminAllAirports'])->name("admin.airports");
	    	Route::get('/airports/search/{search_key?}',[AirportController::class,'getAdminAllAirports'])->name("admin.airports.search");
	    	Route::get('/airports/add',[AirportController::class,'addAirport'])->name("admin.airports.add");  
	    	Route::get('/airports/edit/{airport_id?}',[AirportController::class,'addAirport'])->name("admin.airports.edit");  
		    Route::post('/airports/create/{airport_id?}',[AirportController::class,'createAirport'])->name("admin.airports.create");
		    Route::post('/airports/delete',[AirportController::class,'deleteAirport'])->name("admin.airports.delete");

		    Route::get('/pages',[PageController::class,'getAdminAllPages'])->name("admin.pages");
		    Route::get('/pages/search/{search_key?}',[PageController::class,'getAdminAllPages'])->name("admin.pages.search");
		    Route::get('/pages/add/{page_id?}',[PageController::class,'addPage'])->name("admin.pages.add");  
		    Route::get('/pages/edit/{page_id?}',[PageController::class,'addPage'])->name("admin.pages.edit");  
		    Route::post('/pages/create/{page_id?}',[PageController::class,'createPage'])->name("admin.pages.create");

		    Route::get('/bookWithUs',[BookWithUsControlloer::class,'getAdminAllBookWithUs'])->name("admin.bookWithUs");
		    Route::get('/bookWithUs/search/{search_key?}',[BookWithUsControlloer::class,'getAdminAllBookWithUs'])->name("admin.bookWithUs.search");
		    Route::get('/bookWithUs/add/{id?}',[BookWithUsControlloer::class,'addBookWithUs'])->name("admin.bookWithUs.add");  
		    Route::get('/bookWithUs/edit/{id?}',[BookWithUsControlloer::class,'addBookWithUs'])->name("admin.bookWithUs.edit");  
		    Route::post('/bookWithUs/create/{id?}',[BookWithUsControlloer::class,'createBookWithUs'])->name("admin.bookWithUs.create");
		    Route::post('/bookWithUs/delete',[BookWithUsControlloer::class,'deleteBookWith'])->name("admin.bookWithUs.delete");
		    
		    Route::get('/sidebar-blocks',[SidebarBlocksController::class,'getAdminAllBlocks'])->name("admin.sideBlocks");
		    Route::get('/sidebar-blocks/search/{search_key?}',[SidebarBlocksController::class,'getAdminAllBlocks'])->name("admin.sideBlocks.search");
		    Route::get('/sidebar-blocks/add/{block_id?}',[SidebarBlocksController::class,'addBlock'])->name("admin.sideBlocks.add");  
		    Route::get('/sidebar-blocks/edit/{block_id?}',[SidebarBlocksController::class,'addBlock'])->name("admin.sideBlocks.edit");  
		    Route::post('/sidebar-blocks/create/{block_id?}',[SidebarBlocksController::class,'createSidebarBlock'])->name("admin.sideBlocks.create");
		    Route::post('/sidebar-blocks/delete',[SidebarBlocksController::class,'deleteBlock'])->name("admin.sideBlocks.delete");
	    });  
	});
});
/*** Admin Routes End ****/

