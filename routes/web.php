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

Route::group(['middleware' => 'auth'], function(){
    Route::get('/users/chgpwd/index', 'UserController@changePassword')->name('users.chgpwd');
    Route::put('/users/chgpwd/{user}', 'UserController@updateChangePassword')->name('users.chgpwd.update');
    
    // HOME
    Route::get('/', 'HomeController@index')->name('index');
    Route::get('/home', 'HomeController@index')->name('index');
    Route::get('/dashboard', 'HomeController@index')->name('index');
    Route::get('/accueil', 'HomeController@index')->name('index');

    // PARAMETRES
    Route::get('/parametres', 'ParametresController@index')->name('parametres');

    // PRODUIT
    Route::get('/produits/status/update', 'ProduitController@updateStatus')->name('produits.update.status');
    Route::get('/produits/{produit}', 'ProduitController@show')->name('produits.show');
    // Route::get('/produits/store/new/product', 'ProduitController@store')->name('produits.store');
    Route::post('/produits/store/new/product', 'ProduitController@store')->name('produits.store');
    Route::get('/produits', 'ProduitController@index')->name('produits');
    // Route::get('/produits/update/produit/{produit}', 'ProduitController@update')->name('produits.update');
    Route::put('/produits/update/produit/{produit}', 'ProduitController@update')->name('produits.update');
    Route::patch('/produits/update/produit/{produit}', 'ProduitController@update')->name('produits.update');
    Route::get('/produits/status_del/update', 'ProduitController@destroy')->name('produits.destroy');
    Route::post('/produits/equivalence', 'ProduitController@equivalence')->name('produits.equivalence');
    Route::post('/produits/by/classe', 'ProduitController@getProduitByClasse')->name('produits.getProduitByClasse');
    Route::post('/produits/by/famille', 'ProduitController@getProduitByFamille')->name('produits.getProduitByFamille');

    // VEHICLE TYPE
    Route::get('/vehicletypes/status/update', 'VehicleTypeController@updateStatus')->name('vehicletypes.update.status');
    Route::get('/vehicletypes/{vehicletype}', 'VehicleTypeController@show')->name('vehicletypes.show');
    Route::post('/vehicletypes', 'VehicleTypeController@store')->name('vehicletypes.store');
    Route::get('/vehicletypes', 'VehicleTypeController@index')->name('vehicletypes');
    Route::put('/vehicletypes/{vehicletype}', 'VehicleTypeController@update')->name('vehicletypes.update');
    Route::patch('/vehicletypes/{vehicletype}', 'VehicleTypeController@update')->name('vehicletypes.update');
    Route::get('/vehicletypes/status_del/update', 'VehicleTypeController@destroy')->name('vehicletypes.destroy');

    // COUNTRY
    Route::get('/countries/status/update', 'CountryController@updateStatus')->name('countries.update.status');
    Route::get('/countries/{country}', 'CountryController@show')->name('countries.show');
    Route::post('/countries', 'CountryController@store')->name('countries.store');
    Route::get('/countries', 'CountryController@index')->name('countries');
    Route::put('/countries/{country}', 'CountryController@update')->name('countries.update');
    Route::patch('/countries/{country}', 'CountryController@update')->name('countries.update');
    Route::get('/countries/status_del/update', 'CountryController@destroy')->name('countries.destroy');
    Route::get('/countries/statut/update/{country}', 'CountryController@activate')->name('countries.activate');

    // CURRENCY
    Route::get('/currencies/status/update', 'CurrencyController@updateStatus')->name('currencies.update.status');
    Route::get('/currencies/{currency}', 'CurrencyController@show')->name('currencies.show');
    Route::post('/currencies', 'CurrencyController@store')->name('currencies.store');
    Route::get('/currencies', 'CurrencyController@index')->name('currencies');
    Route::put('/currencies/{currency}', 'CurrencyController@update')->name('currencies.update');
    Route::patch('/currencies/{currency}', 'CurrencyController@update')->name('currencies.update');
    Route::get('/currencies/status_del/update', 'CurrencyController@destroy')->name('currencies.destroy');
    Route::get('/currencies/statut/update/{currency}', 'CurrencyController@activate')->name('currencies.activate');

    // COMMISSION
    Route::get('/commissions/status/update', 'CommissionController@updateStatus')->name('commissions.update.status');
    Route::get('/commissions/{commission}', 'CommissionController@show')->name('commissions.show');
    Route::post('/commissions', 'CommissionController@store')->name('commissions.store');
    Route::get('/commissions', 'CommissionController@index')->name('commissions');
    Route::put('/commissions/{commission}', 'CommissionController@update')->name('commissions.update');
    Route::patch('/commissions/{commission}', 'CommissionController@update')->name('commissions.update');
    Route::get('/commissions/status_del/update', 'CommissionController@destroy')->name('commissions.destroy');

    // PAYMENT METHOD
    Route::get('/paymentmethods/status/update', 'PaymentMethodController@updateStatus')->name('paymentmethods.update.status');
    Route::get('/paymentmethods/{paymentmethod}', 'PaymentMethodController@show')->name('paymentmethods.show');
    Route::post('/paymentmethods', 'PaymentMethodController@store')->name('paymentmethods.store');
    Route::get('/paymentmethods', 'PaymentMethodController@index')->name('paymentmethods');
    Route::put('/paymentmethods/{paymentmethod}', 'PaymentMethodController@update')->name('paymentmethods.update');
    Route::patch('/paymentmethods/{paymentmethod}', 'PaymentMethodController@update')->name('paymentmethods.update');
    Route::get('/paymentmethods/status_del/update', 'PaymentMethodController@destroy')->name('paymentmethods.destroy');
    Route::get('/paymentmethods/statut/update/{paymentmethod}', 'PaymentMethodController@activate')->name('paymentmethods.activate');

    // SETTINGS
    Route::get('/settings/status/update', 'SettingController@updateStatus')->name('settings.update.status');
    Route::get('/settings/{setting}', 'SettingController@show')->name('settings.show');
    Route::post('/settings', 'SettingController@store')->name('settings.store');
    Route::get('/settings', 'SettingController@index')->name('settings');
    Route::put('/settings/{setting}', 'SettingController@update')->name('settings.update');
    Route::patch('/settings/{setting}', 'SettingController@update')->name('settings.update');
    Route::get('/settings/status_del/update', 'SettingController@destroy')->name('settings.destroy');

    // VEHICLE TYPE RENTAL
    Route::get('/vehicletyperentals/status/update', 'VehicleTypeRentalController@updateStatus')->name('vehicletyperentals.update.status');
    Route::get('/vehicletyperentals/{vehicletyperental}', 'VehicleTypeRentalController@show')->name('vehicletyperentals.show');
    Route::post('/vehicletyperentals', 'VehicleTypeRentalController@store')->name('vehicletyperentals.store');
    Route::get('/vehicletyperentals', 'VehicleTypeRentalController@index')->name('vehicletyperentals');
    Route::put('/vehicletyperentals/{vehicletyperental}', 'VehicleTypeRentalController@update')->name('vehicletyperentals.update');
    Route::patch('/vehicletyperentals/{vehicletyperental}', 'VehicleTypeRentalController@update')->name('vehicletyperentals.update');
    Route::get('/vehicletyperentals/status_del/update', 'VehicleTypeRentalController@destroy')->name('vehicletyperentals.destroy');

    // VEHICLE RENTAL
    Route::get('/vehiclerentals/status/update', 'VehicleRentalController@updateStatus')->name('vehiclerentals.update.status');
    Route::get('/vehiclerentals/{vehiclerental}', 'VehicleRentalController@show')->name('vehiclerentals.show');
    Route::post('/vehiclerentals', 'VehicleRentalController@store')->name('vehiclerentals.store');
    Route::get('/vehiclerentals', 'VehicleRentalController@index')->name('vehiclerentals');
    Route::put('/vehiclerentals/{vehiclerental}', 'VehicleRentalController@update')->name('vehiclerentals.update');
    Route::patch('/vehiclerentals/{vehiclerental}', 'VehicleRentalController@update')->name('vehiclerentals.update');
    Route::get('/vehiclerentals/status_del/update', 'VehicleRentalController@destroy')->name('vehiclerentals.destroy');

    // VEHICLE RENT
    Route::get('/vehiclerents/status/update', 'VehicleRentController@updateStatus')->name('vehiclerents.update.status');
    Route::get('/vehiclerents/{vehiclerent}', 'VehicleRentController@show')->name('vehiclerents.show');
    Route::post('/vehiclerents', 'VehicleRentController@store')->name('vehiclerents.store');
    Route::get('/vehiclerents', 'VehicleRentController@index')->name('vehiclerents');
    Route::put('/vehiclerents/{vehiclerent}', 'VehicleRentController@update')->name('vehiclerents.update');
    Route::patch('/vehiclerents/{vehiclerent}', 'VehicleRentController@update')->name('vehiclerents.update');
    Route::get('/vehiclerents/status_del/update', 'VehicleRentController@destroy')->name('vehiclerents.destroy');

    // USER APP
    Route::get('/userapps/status/update', 'UserAppController@updateStatus')->name('userapps.update.status');
    Route::get('/userapps/{userapp}', 'UserAppController@show')->name('userapps.show');
    Route::post('/userapps', 'UserAppController@store')->name('userapps.store');
    Route::get('/userapps', 'UserAppController@index')->name('userapps');
    Route::put('/userapps/{userapp}', 'UserAppController@update')->name('userapps.update');
    Route::patch('/userapps/{userapp}', 'UserAppController@update')->name('userapps.update');
    Route::get('/userapps/status_del/update', 'UserAppController@destroy')->name('userapps.destroy');
    Route::get('/userapps/statut/update/{userapp}', 'UserAppController@activate')->name('userapps.activate');

    // REQUEST ORDER
    Route::get('/requestorders/status/update', 'RequestOrderController@updateStatus')->name('requestorders.update.status');
    Route::get('/requestorders/{requestorder}', 'RequestOrderController@show')->name('requestorders.show');
    Route::post('/requestorders', 'RequestOrderController@store')->name('requestorders.store');
    Route::get('/requestorders', 'RequestOrderController@index')->name('requestorders');
    Route::put('/requestorders/{requestorder}', 'RequestOrderController@update')->name('requestorders.update');
    Route::patch('/requestorders/{requestorder}', 'RequestOrderController@update')->name('requestorders.update');
    Route::get('/requestorders/status_del/update', 'RequestOrderController@destroy')->name('requestorders.destroy');
    Route::get('/requestorders/status/{status}', 'RequestOrderController@byStatus')->name('requestorders.byStatus');
    Route::get('/requestorders/stats/earning/{year}', 'RequestOrderController@getEarningStatsDashboard')->name('requestorders.stats.earning.dashboard');
    Route::get('/requestorders/stats/earning', 'RequestOrderController@getEarningStats')->name('requestorders.stats.earning');

    // REQUEST BOOK
    Route::get('/requestbooks/status/update', 'RequestBookController@updateStatus')->name('requestbooks.update.status');
    Route::get('/requestbooks/{requestbook}', 'RequestBookController@show')->name('requestbooks.show');
    Route::post('/requestbooks', 'RequestBookController@store')->name('requestbooks.store');
    Route::get('/requestbooks', 'RequestBookController@index')->name('requestbooks');
    Route::put('/requestbooks/{requestbook}', 'RequestBookController@update')->name('requestbooks.update');
    Route::patch('/requestbooks/{requestbook}', 'RequestBookController@update')->name('requestbooks.update');
    Route::get('/requestbooks/status_del/update', 'RequestBookController@destroy')->name('requestbooks.destroy');

    // CONDUCTEUR
    Route::get('/conducteurs/status/update', 'ConducteurController@updateStatus')->name('conducteurs.update.status');
    Route::get('/conducteurs/{conducteur}', 'ConducteurController@show')->name('conducteurs.show');
    Route::post('/conducteurs', 'ConducteurController@store')->name('conducteurs.store');
    Route::get('/conducteurs', 'ConducteurController@index')->name('conducteurs');
    Route::put('/conducteurs/{conducteur}', 'ConducteurController@update')->name('conducteurs.update');
    Route::patch('/conducteurs/{conducteur}', 'ConducteurController@update')->name('conducteurs.update');
    Route::get('/conducteurs/status_del/update', 'ConducteurController@destroy')->name('conducteurs.destroy');
    Route::get('/conducteurs/statut/update/{conducteur}', 'ConducteurController@activate')->name('conducteurs.activate');
    Route::get('/conducteurs/get/all', 'ConducteurController@all')->name('conducteurs.all');
    Route::get('/conducteursdetails', 'ConducteurController@showSingle')->name('conducteurs.single');

    // NOTIFICATION
    Route::get('/notifications/status/update', 'NotificationController@updateStatus')->name('notifications.update.status');
    Route::get('/notifications/{notification}', 'NotificationController@show')->name('notifications.show');
    Route::post('/notifications', 'NotificationController@store')->name('notifications.store');
    Route::get('/notifications', 'NotificationController@index')->name('notifications');
    Route::put('/notifications/{notification}', 'NotificationController@update')->name('notifications.update');
    Route::patch('/notifications/{notification}', 'NotificationController@update')->name('notifications.update');
    Route::get('/notifications/status_del/update', 'NotificationController@destroy')->name('notifications.destroy');

    // STASTISTIC USER APP
    Route::get('/statisticuserapps/status/update', 'StatisticUserAppController@updateStatus')->name('statisticuserapps.update.status');
    Route::get('/statisticuserapps/{statisticuserapp}', 'StatisticUserAppController@show')->name('statisticuserapps.show');
    Route::post('/statisticuserapps', 'StatisticUserAppController@store')->name('statisticuserapps.store');
    Route::get('/statisticuserapps', 'StatisticUserAppController@index')->name('statisticuserapps');
    Route::put('/statisticuserapps/{statisticuserapp}', 'StatisticUserAppController@update')->name('statisticuserapps.update');
    Route::patch('/statisticuserapps/{statisticuserapp}', 'StatisticUserAppController@update')->name('statisticuserapps.update');
    Route::get('/statisticuserapps/status_del/update', 'StatisticUserAppController@destroy')->name('statisticuserapps.destroy');

    // STASTISTIC CONDUCTEUR
    Route::get('/statisticconducteurs/status/update', 'StatisticConducteurController@updateStatus')->name('statisticconducteurs.update.status');
    Route::get('/statisticconducteurs/{statisticconducteur}', 'StatisticConducteurController@show')->name('statisticconducteurs.show');
    Route::post('/statisticconducteurs', 'StatisticConducteurController@store')->name('statisticconducteurs.store');
    Route::get('/statisticconducteurs', 'StatisticConducteurController@index')->name('statisticconducteurs');
    Route::put('/statisticconducteurs/{statisticconducteur}', 'StatisticConducteurController@update')->name('statisticconducteurs.update');
    Route::patch('/statisticconducteurs/{statisticconducteur}', 'StatisticConducteurController@update')->name('statisticconducteurs.update');
    Route::get('/statisticconducteurs/status_del/update', 'StatisticConducteurController@destroy')->name('statisticconducteurs.destroy');

    // STASTISTIC EARNING
    Route::get('/statisticearnings/status/update', 'StatisticEarningController@updateStatus')->name('statisticearnings.update.status');
    Route::get('/statisticearnings/{statisticearning}', 'StatisticEarningController@show')->name('statisticearnings.show');
    Route::post('/statisticearnings', 'StatisticEarningController@store')->name('statisticearnings.store');
    Route::get('/statisticearnings', 'StatisticEarningController@index')->name('statisticearnings');
    Route::put('/statisticearnings/{statisticearning}', 'StatisticEarningController@update')->name('statisticearnings.update');
    Route::patch('/statisticearnings/{statisticearning}', 'StatisticEarningController@update')->name('statisticearnings.update');
    Route::get('/statisticearnings/status_del/update', 'StatisticEarningController@destroy')->name('statisticearnings.destroy');

    // LANGUE
    Route::get('/langues/status/update/{langue}', 'LangueController@activate')->name('langues.update.status');
    Route::get('/langues/{langue}', 'LangueController@show')->name('langues.show');
    Route::post('/langues', 'LangueController@store')->name('langues.store');
    Route::get('/langues', 'LangueController@index')->name('langues');
    Route::put('/langues/{langue}', 'LangueController@update')->name('langues.update');
    Route::patch('/langues/{langue}', 'LangueController@update')->name('langues.update');
    Route::get('/langues/status_del/update', 'LangueController@destroy')->name('langues.destroy');
});

// LANGUE CHANGE
Route::get('lang/locale', 'LocalizationController@index')->name('lang.change');

Route::get('/login', 'Auth\LoginController@index')->name('login');

Route::get('/error404', function () {
    return view('error404');
})->name('error404');

Route::fallback(function(){
    return redirect()->route('error404');
})->name('api.fallback.404');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
