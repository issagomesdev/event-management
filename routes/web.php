<?php

Route::get('/', 'SiteController@index')->name('site.home');

Route::get('/event-details/{id}/{name}', 'SiteController@EventDetails')->name('site.event.details');
Route::get('/event-details/{id}/{name}/list', 'SiteController@AttendanceList')->name('site.event.list')->middleware('list.password');
Route::get('/event-details/{id}/{name}/checkin', 'SiteController@CheckinList')->name('site.event.checkin')->middleware('list.password');
Route::post('events-checkin/{id}/{eventID}/{action}/{type}', 'SiteController@toCheckIn')->name('site.events.toCheckIn');

Route::post('/confirm-attendance/{eventID}', 'SiteController@confirmAttendance')->name('confirm.attendance.event');
Route::post('/redirect-whatsapp', 'SiteController@redirectWhatsapp')->name('redirect.whatsapp');
Route::post('/save-guests/{eventID}', 'SiteController@saveGuests')->name('save.guests.event');
Route::post('/add-guest/{eventID}/{customerID}', 'SiteController@addGuest')->name('add.guest.event');
Route::post('/delete-guest/{guestID}', 'SiteController@deleteGuest')->name('delete.guest.event');

Route::get('/customer/login', 'SiteController@CustomerLogin')->name('customers.login');

Route::get('/customer/register', 'SiteController@CustomerRegister')->name('customers.register');

Route::get('/customer/logout', 'SiteController@CustomerLogout')->name('customers.logout');

Route::get('customers/searchWithPhone/{number}', 'SiteController@searchWithPhone')->name('customers.searchWithPhone');

Route::post('/verify-customer', 'SiteController@verifyCustomer')->name('customers.verifyCustomer');
Route::post('customers', 'SiteController@CustomerStore')->name('customers.store');

Auth::routes(['register' => false]);

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {
    Route::get('/', 'HomeController@index')->name('home');
    // Permissions
    Route::resource('permissions', 'PermissionsController', ['except' => ['create', 'store', 'edit', 'update', 'destroy']]);

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::resource('users', 'UsersController');

    // Customer
    Route::delete('customers/destroy', 'CustomerController@massDestroy')->name('customers.massDestroy');
    Route::resource('customers', 'CustomerController');

    // Event
    Route::delete('events/destroy', 'EventController@massDestroy')->name('events.massDestroy');
    Route::post('events/media', 'EventController@storeMedia')->name('events.storeMedia');
    Route::post('events/ckmedia', 'EventController@storeCKEditorImages')->name('events.storeCKEditorImages');
    Route::get('events/{id}/checkin', 'EventController@checkin')->name('events.checkin');
    Route::post('events-checkin/{id}/{eventID}/{action}/{type}', 'EventController@toCheckIn')->name('events.toCheckIn');
    Route::resource('events', 'EventController');

    // Configs
    Route::delete('configs/destroy', 'ConfigsController@massDestroy')->name('configs.massDestroy');
    Route::resource('configs', 'ConfigsController');
});

Route::group(['prefix' => 'profile', 'as' => 'profile.', 'namespace' => 'Auth', 'middleware' => ['auth']], function () {
    // Change password
    if (file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php'))) {
        Route::get('password', 'ChangePasswordController@edit')->name('password.edit');
        Route::post('password', 'ChangePasswordController@update')->name('password.update');
        Route::post('profile', 'ChangePasswordController@updateProfile')->name('password.updateProfile');
        Route::post('profile/destroy', 'ChangePasswordController@destroy')->name('password.destroyProfile');
    }
});
