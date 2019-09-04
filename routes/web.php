<?php

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//products routes
Route::get('/raw_foodstuffs', 'ProductPageController@getFoodStuff')->name('foodstuff');
Route::get('/raw_foodstuff/{id}/{name}', 'ProductPageController@getFoodStuff');
Route::get('/raw_foodstuff/{id}/images/products/organic/{any}', 'ProductPageController@getFoodStuff');
Route::get('/images/products/organic/{any}', 'ProductPageController@getFoodStuff');
Route::get('/soup-stew-ingredients', 'ProductPageController@getSoupRecipes')->name('soup_recipes');
Route::get('/soup-stew-ingredients/{id}/{slug}', 'ProductPageController@getSoupRecipes');
Route::get('/images/products/recipes/{any}', 'ProductPageController@getSoupRecipes');
Route::get('/fish-meat', 'ProductPageController@getProteins')->name('proteins');
Route::get('/fish-meat/{id}/{slug}', 'ProductPageController@getProteins');
Route::get('/images/products/proteins/{slug}', 'ProductPageController@getProteins');
Route::get('/fruits-vegetables', 'ProductPageController@getFruitsVegs')->name('fruits_vegs');
Route::get('/fruits-vegetables/{id}/{slug}', 'ProductPageController@getFruitsVegs');
Route::get('/images/products/fruits_vegs/{slug}', 'ProductPageController@getProteins');
Route::get('/herbs-spices', 'ProductPageController@getHerbsSpices')->name('herbs_spices');
Route::get('/herbs-spices/{id}/{slug}', 'ProductPageController@getHerbsSpices');
Route::get('/images/products/herbs_spices/{slug}', 'ProductPageController@getHerbsSpices');
Route::get('/coffee-tea', 'ProductPageController@getCoffeeTea')->name('coffee_tea');
Route::get('/coffee-tea/{id}/{slug}', 'ProductPageController@getCoffeeTea');
Route::get('/images/products/cofee_tea/{slug}', 'ProductPageController@getCoffeeTea');
Route::get('/beverages-drinks-water', 'ProductPageController@getBeveragesDrinks')->name('drinks');
Route::get('/beverages-drinks-water/{id}/{slug}', 'ProductPageController@getBeveragesDrinks');
Route::get('/images/products/drinks/{slug}', 'ProductPageController@getBeveragesDrinks');
Route::get('/breakfast-cereal', 'ProductPageController@getBreakfastCereal')->name('breakfast_cereal');
Route::get('/breakfast-cereal/{id}/{slug}', 'ProductPageController@getBreakfastCereal');
Route::get('/images/products/cereal/{slug}', 'ProductPageController@getBreakfastCereal');
Route::get('/eggs-dairy', 'ProductPageController@getEggsDairy')->name('eggs_dairy');
Route::get('/eggs-dairy/{id}/{slug}', 'ProductPageController@getEggsDairy');
Route::get('/images/products/eggs_dairy/{slug}', 'ProductPageController@getEggsDairy');
Route::get('/toiletries', 'ProductPageController@getToiletries')->name('toiletries');
Route::get('/toiletries/{id}/{slug}', 'ProductPageController@getToiletries');
Route::get('/images/products/toiletries/{slug}', 'ProductPageController@getToiletries');
Route::get('/household', 'ProductPageController@getHousehold')->name('household');
Route::get('/household/{id}/{slug}', 'ProductPageController@getHousehold');
Route::get('/images/products/household/{slug}', 'ProductPageController@getHousehold');
Route::get('/groceries', 'ProductPageController@getGroceries')->name('groceries');
Route::get('/groceries/{id}/{slug}', 'ProductPageController@getGroceries');
Route::get('/images/products/groceries/{slug}', 'ProductPageController@getGroceries');
Route::get('/kitchen', 'ProductPageController@getKitchen')->name('kitchen');
Route::get('/kitchen/{id}/{slug}', 'ProductPageController@getKitchen');
Route::get('/special_order', 'ProductPageController@getSpecialOrder')->name('special.order');
Route::get('/special_services/services', 'ProductPageController@services')->name('services');
// Route::get('/test', 'ProductPageController@services')->name('services');

//cart
Route::get('/my_cart', 'ProductPageController@cart')->name('cart');

//api calls
Route::get('/get_products/{id}', 'ProductController@getProducts');
Route::post('/search_for_product', 'ProductController@search');
Route::get('/get_product/{id}', 'ProductController@getSingleProduct');
Route::get('/get_similar_products/{cat}/{id}', 'ProductController@getSimilarProducts');
Route::get('/get_products_categories/{id}', 'ProductController@getProductsByCats');
Route::post('/post_special_orders', 'OrderController@sendSpecialOrder');
Route::get('/get_services', 'ServicesController@getServices');
Route::post('/pay_ondelivery', 'OrderController@payOnDelivery');
Route::post('/send_orderreceived_emails', 'OrderController@sendOrderReceivedEmails');
