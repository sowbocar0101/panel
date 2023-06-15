<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();

});

// VEHICLE TYPE
Route::POST('/vehicletypes', 'VehicleTypeController@getVehicleTypeAPI');

// DRIVERS
Route::get('/drivers', 'ConducteurController@getDriversAPI');
Route::post('/drivers/register', 'ConducteurController@store');
Route::post('/drivers/login', 'ConducteurController@login');
Route::post('/drivers/update/email', 'ConducteurController@setEmail');
Route::post('/drivers/update/password', 'ConducteurController@setPassword');
Route::post('/drivers/update/phone', 'ConducteurController@setPhone');
Route::post('/drivers/update/nom', 'ConducteurController@setNom');
Route::post('/drivers/update/prenom', 'ConducteurController@setPrenom');
// Route::post('/drivers/update/photo', 'ConducteurController@setPhoto');
Route::post('/drivers/update/vehicle', 'ConducteurController@setVehicle');
Route::post('/drivers/update/vehicle/brand', 'ConducteurController@setVehicleBrand');
Route::post('/drivers/update/vehicle/model', 'ConducteurController@setVehicleModel');
Route::post('/drivers/update/vehicle/color', 'ConducteurController@setVehicleColor');
Route::post('/drivers/update/vehicle/numberplate', 'ConducteurController@setVehicleNumberPlate');
Route::post('/drivers/update/amount', 'ConducteurController@setAmount');
Route::post('/drivers/update/position', 'ConducteurController@setPosition');
Route::post('/drivers/update/fcm', 'ConducteurController@setFCM');
Route::post('/drivers/update/licence', 'ConducteurController@setLicence');
Route::post('/drivers/update/licence/ios', 'ConducteurController@setLicenceIOS');
Route::post('/drivers/update/nic', 'ConducteurController@setNic');
Route::post('/drivers/update/nic/ios', 'ConducteurController@setNicIOS');
Route::post('/drivers/update/photo', 'ConducteurController@setPhoto');
Route::post('/drivers/update/photo/ios', 'ConducteurController@setPhotoIOS');
Route::post('/drivers/reviews', 'ConducteurController@getReview');
Route::post('/drivers/get/drivers', 'ConducteurController@getDrivers');
Route::post('/drivers/get/taxis', 'ConducteurController@getTaxis');
Route::post('/drivers/get/wallet', 'ConducteurController@getWallet');
Route::post('/drivers/change/status', 'ConducteurController@changeStatus');
Route::post('/drivers/dashboard', 'ConducteurController@getDashboard');

// CUSTOMER
Route::post('/customers/register', 'UserAppController@store');
Route::post('/customers/login', 'UserAppController@login');
Route::post('/customers/update/email', 'UserAppController@setEmail');
Route::post('/customers/update/password', 'UserAppController@setPassword');
Route::post('/customers/update/phone', 'UserAppController@setPhone');
Route::post('/customers/update/nom', 'UserAppController@setNom');
Route::post('/customers/update/prenom', 'UserAppController@setPrenom');
// Route::post('/customers/update/photo', 'UserAppController@setPhoto');
Route::post('/customers/update/amount', 'UserAppController@setAmount');
Route::post('/customers/update/fcm', 'UserAppController@setFCM');
Route::post('/customers/update/photo', 'UserAppController@setPhoto');
Route::post('/customers/update/photo/ios', 'UserAppController@setPhotoIOS');
Route::post('/customers/favorites', 'UserAppController@getFavorite');
Route::post('/customers/vehicle/rent/location', 'UserAppController@getLocation');
Route::post('/customers/get/wallet', 'UserAppController@getWallet');

// VEHICLE RENT
Route::post('/vehiclerents/register', 'VehicleRentController@store');
Route::post('/vehiclerents/cancel', 'VehicleRentController@cancelBooking');

// NOTE
Route::post('/notes/register', 'NoteController@store');

// FAVORITE RIDE
Route::post('/favoriterides/register', 'FavoriteRideController@store');
Route::post('/favoriterides/delete', 'FavoriteRideController@deleteFavorite');

// REQUEST ORDER
Route::post('/requestorders/register', 'RequestOrderController@store');
Route::post('/requestorders/ios/register', 'RequestOrderController@storeIOS');
Route::post('/requestorders/completed/driver', 'RequestOrderController@getCompletedRequestDriver');
Route::post('/requestorders/confirmed/driver', 'RequestOrderController@getConfirmedRequestDriver');
Route::post('/requestorders/onride/driver', 'RequestOrderController@getOnRideRequestDriver');
Route::post('/requestorders/rejected/driver', 'RequestOrderController@getRejectedRequestDriver');
Route::post('/requestorders/new/driver', 'RequestOrderController@getNewRequestDriver');
Route::post('/requestorders/completed/get', 'RequestOrderController@getCompletedRequest');
Route::post('/requestorders/confirmed', 'RequestOrderController@getConfirmedRequest');
Route::post('/requestorders/onride/get', 'RequestOrderController@getOnRideRequest');
Route::post('/requestorders/rejected', 'RequestOrderController@getCanceledRequest');
Route::post('/requestorders/new', 'RequestOrderController@getNewRequest');
Route::post('/requestorders/onride', 'RequestOrderController@onRideRequest');
Route::post('/requestorders/payment/wallet', 'RequestOrderController@payRequestWallet');
Route::post('/requestorders/payment', 'RequestOrderController@payRequest');
Route::post('/requestorders/reject', 'RequestOrderController@rejectRequest');
Route::post('/requestorders/cancel', 'RequestOrderController@cancelRequest');
Route::post('/requestorders/completed', 'RequestOrderController@completedRequest');
Route::post('/requestorders/confirm', 'RequestOrderController@confirmRequest');

// REQUEST BOOK
Route::post('/requestbooks/register', 'RequestBookController@store');
Route::post('/requestbooks/ios/register', 'RequestBookController@storeIOS');
Route::post('/requestbooks/canceled', 'RequestBookController@getCanceledRequest');
Route::post('/requestbooks/confirmed', 'RequestBookController@getConfirmedRequest');
Route::post('/requestbooks/new', 'RequestBookController@getNewRequest');
Route::post('/requestbooks/confirmed/driver', 'RequestBookController@getConfirmedRequestDriver');
Route::post('/requestbooks/new/driver', 'RequestBookController@getNewRequestDriver');
Route::post('/requestbooks/rejected/driver', 'RequestBookController@getRejectedRequestDriver');
Route::post('/requestbooks/onride', 'RequestBookController@onRideRequest');
Route::post('/requestbooks/reject', 'RequestBookController@rejectRequest');
Route::post('/requestbooks/cancel', 'RequestBookController@cancelRequest');
Route::post('/requestbooks/confirm', 'RequestBookController@confirmRequest');

// PAYEMENT METHOD
Route::post('/paymentmethods', 'PaymentMethodController@getPaymentMethod');

// TRANSACTION
Route::post('/transactions', 'TransactionController@getTransactions');

// VEHICLE RENTAL
Route::post('/vehiclerentals', 'VehicleRentalController@getVehicles');

// STATISTIC
Route::post('/stats/earning', 'RequestOrderController@getEarningStatsWeek');
