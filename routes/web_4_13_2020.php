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

Route::get('/test', function () { return view('auth.login'); });
Route::get('/cache-clear', function() {
    $exitCode = Artisan::call('config:clear');
    $exitCode = Artisan::call('cache:clear');
    $exitCode = Artisan::call('config:cache');
    $exitCode = Artisan::call('view:clear');
    $exitCode = Artisan::call('route:cache');
    $exitCode = Artisan::call('route:clear');
    $exitCode = Artisan::call('migrate');
    $exitCode = Artisan::call('optimize');
    return 'DONE'; //Return anything
});
Auth::routes();


Route::get('/admin/login', 'Auth\LoginController@showLoginForm')->name('admin/login');
Route::post('/login', 'Auth\LoginController@login')->name('login');

Route::group(['middleware' => ['auth'], 'namespace' => 'Backend'], function() {
    Route::get('/admin/dashboard', 'DashboardController@index');
    //User Master
    Route::group(['middleware' => ['permission:User Master']], function() {
        Route::get('/admin/front-users', 'UserController@FrontUser')->name('front-users')->middleware(['permission:User List']);
        Route::get('/admin/front-users-create', 'UserController@CreateFrontUser')->name('front-users-create')->middleware(['permission:User Create']);
        Route::post('/admin/save-front-users', 'UserController@SaveFrontUsers')->name('save-front-users');

        Route::get('/admin/users', 'UserController@index')->name('user-list')->middleware(['permission:User List']);
        Route::get('/admin/users/create', 'UserController@create')->name('user-create')->middleware(['permission:User Create']);
        Route::post('/admin/users/store', 'UserController@store')->name('user-save')->middleware(['permission:User Create']);
        Route::get('/admin/users/edit/{id}', 'UserController@edit')->name('user-edit')->middleware(['permission:User Edit']);
        Route::post('/admin/users/update/{id}', 'UserController@update')->name('user-update')->middleware(['permission:User Edit']);
        Route::get('/admin/ajax/users/view/{id}', 'UserController@show')->name('user-view')->middleware(['permission:User View']);
    });

    //Banner Master
    Route::group(['middleware' => ['permission:Banner Master']], function() {
        Route::get('/admin/banner-list', 'BannerController@index')->name('banner-list')->middleware(['permission:Banner List']);
        Route::get('/admin/banner/create', 'BannerController@create')->name('banner-create')->middleware(['permission:Banner Create']);
        Route::post('/admin/banner/store', 'BannerController@store')->name('banner-store')->middleware(['permission:Banner Create']);
        Route::get('/admin/banner/edit/{id}', 'BannerController@edit')->name('banner-edit')->middleware(['permission:Banner Edit']);
        Route::post('/admin/banner/update/{id}', 'BannerController@update')->name('banner-update')->middleware(['permission:Banner Edit']);
        Route::get('/admin/banner/delete/{id}', 'BannerController@destroy')->name('banner-delete')->middleware(['permission:Banner Delete']);
    });

    //Testimonial Master
    Route::group(['middleware' => ['permission:Testimonial Master']], function() {
        Route::get('/admin/testimonial-list', 'TestimonialController@index')->name('testimonial-list')->middleware(['permission:Testimonial List']);
        Route::get('/admin/testimonial/create', 'TestimonialController@create')->name('testimonial-create')->middleware(['permission:Testimonial Create']);
        Route::post('/admin/testimonial/store', 'TestimonialController@store')->name('testimonial-store')->middleware(['permission:Testimonial Create']);
        Route::get('/admin/testimonial/edit/{id}', 'TestimonialController@edit')->name('testimonial-edit')->middleware(['permission:Testimonial Edit']);
        Route::post('/admin/testimonial/update/{id}', 'TestimonialController@update')->name('testimonial-update')->middleware(['permission:Testimonial Edit']);
        Route::get('/admin/testimonial/delete/{id}', 'TestimonialController@destroy')->name('testimonial-delete')->middleware(['permission:Testimonial Delete']);
    });

        //Blog Master
        Route::group(['middleware' => ['permission:Blog Master']], function() {
            Route::get('/admin/blog-list', 'BlogController@index')->name('blog-list')->middleware(['permission:Blog List']);
            Route::get('/admin/blog/create', 'BlogController@create')->name('blog-create')->middleware(['permission:Blog Create']);
            Route::post('/admin/blog/store', 'BlogController@store')->name('blog-store')->middleware(['permission:Blog Create']);
            Route::get('/admin/blog/edit/{id}', 'BlogController@edit')->name('blog-edit')->middleware(['permission:Blog Edit']);
            Route::post('/admin/blog/update/{id}', 'BlogController@update')->name('blog-update')->middleware(['permission:Blog Edit']);
            Route::get('/admin/blog/delete/{id}', 'BlogController@destroy')->name('blog-delete')->middleware(['permission:Blog Delete']);
        });

    //Category Master
    Route::group(['middleware' => ['permission:Category Master']], function() {
        Route::get('/admin/category', 'CategoryController@index')->name('category-list')->middleware(['permission:Category List']);
        Route::get('/admin/category/create', 'CategoryController@create')->name('category-create')->middleware(['permission:Category Create']);
        Route::post('/admin/category/store', 'CategoryController@store')->name('category-save')->middleware(['permission:Category Create']);
        Route::get('/admin/category/edit/{id}', 'CategoryController@edit')->name('category-edit')->middleware(['permission:Category Edit']);
        Route::post('/admin/category/update/{id}', 'CategoryController@update')->name('category-update')->middleware(['permission:Category Edit']);
        Route::get('/admin/ajax/category/view/{id}', 'CategoryController@show')->name('category-view')->middleware(['permission:Category View']);
    });

    //Fund Raiser Master
    Route::group(['middleware' => ['permission:Fund Raiser Master']], function() {
        //Fund Raise Story
           Route::get('/admin/fundraise/fundraise-story', 'FundRaiserController@FundRaiseStoryList')->name('fund-raise-story-list')->middleware(['permission:Fund Raiser List']);
           Route::get('/admin/fundraise/fundraise-story/create', 'FundRaiserController@FundRaiseStoryCreate')->name('fund-raise-story-create')->middleware(['permission:Fund Raiser Create']);
           Route::post('/admin/fundraise/fundraise-story/store', 'FundRaiserController@FundRaiseStoryCreateStore')->name('fund-raise-story-store')->middleware(['permission:Fund Raiser Create']);
           Route::get('/admin/fundraise/fundraise-story/edit/{id}', 'FundRaiserController@FundRaiseStoryedit')->name('fund-raise-story-edit')->middleware(['permission:Fund Raiser Edit']);
           Route::post('/admin/fundraise/fundraise-story/update/{id}', 'FundRaiserController@FundRaiseStoryupdate')->name('fund-raise-story-update')->middleware(['permission:Fund Raiser Edit']);


           Route::get('/admin/fundraise', 'FundRaiserController@index')->name('fund-raise-list')->middleware(['permission:Fund Raiser List']);
           Route::get('/admin/fundraise/create', 'FundRaiserController@create')->name('fund-raise-create')->middleware(['permission:Fund Raiser Create']);
           Route::post('/fundraise/store', 'FundRaiserController@store')->name('fund-raise-store')->middleware(['permission:Fund Raiser Create']);
           Route::get('/admin/fundraise/edit/{id}', 'FundRaiserController@edit')->name('fund-raise-edit')->middleware(['permission:Fund Raiser Edit']);
           Route::post('/admin/fundraise/update/{id}', 'FundRaiserController@update')->name('fund-raise-update')->middleware(['permission:Fund Raiser Edit']);
           Route::get('/admin/fundraise/delete-image', 'FundRaiserController@DeleteSingleImage')->name('delete-image')->middleware(['permission:Fund Raiser Edit']);
        });


    /* Package Controller  */
    Route::get('chart', 'ChartController@index');

    Route::post('site-register', 'SiteAuthController@siteRegisterPost');
    Route::get('search', 'PackageController@index')->name('search');
    Route::get('autocomplete', 'PackageController@autocomplete')->name('autocomplete');
    Route::get('pdfview',array('as'=>'pdfview','uses'=>'PackageController@pdfview'));
    /* Package Controller  */
    Route::get('/setting', 'SettingController@index')->name('setting');
    Route::post('/setting/password/update', 'SettingController@updatePassword')->name('password-update');
    Route::get('/admin/roles-list', 'RolePermissionController@roles')->name('roles-list');
    Route::get('/admin/roles/create', 'RolePermissionController@create')->name('roles-create');
    Route::post('/admin/roles/store', 'RolePermissionController@store')->name('roles-store');
    Route::get('/admin/roles/edit/{id}', 'RolePermissionController@edit')->name('roles-edit');
    Route::post('/admin/roles/update/{id}', 'RolePermissionController@update')->name('roles-update');
    Route::get('/admin/ajax/roles/view/{id}', 'RolePermissionController@show')->name('roles-view');
});

/* Front Routes --  */
Route::get('site-register', 'Backend\SiteAuthController@siteRegister');
Route::post('save-site-register', 'Backend\SiteAuthController@SavesiteRegister');



Route::group(['namespace' => 'Frontend'], function() {
    Route::get('/', 'HomeController@index')->name('index');
     Route::get('/register', 'FrontUserController@index')->name('register-user');
     Route::post('/users', 'FrontUserController@store')->name('save-register');
     Route::get('/login',    'FrontUserController@LoginUser')->name('login-user');
     Route::get('/about-us',    'HomeController@AboutUs')->name('about-us');
     Route::get('/blog/{id}/{blogtitle}',    'HomeController@SingleBlogData')->name('single-blog');
     Route::post('/checklogin', 'LoginController@checkLogin')->name('check-login');
});


Route::group(['middleware' => ['isLogin'], 'namespace' => 'Frontend'], function() {
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
    /* Fund  Raiser */
    Route::get('/start-fundraiser', 'FundRaiserController@create')->name('start-fundraiser');
    Route::post('/save-fundraiser', 'FundRaiserController@store')->name('save-fundraiser');
    Route::get('/my-contribution-fundraiser', 'FundRaiserController@MyContributionFundRaiser')->name('my-contribution-fundraiser');
    Route::get('/get-doc', 'FundRaiserController@GetDocumentByUserId')->name('get-doc');
    Route::get('/search-data', 'FundRaiserController@SearchData')->name('search-data');
    Route::get('/get-data-by-autocomplete', 'FundRaiserController@GetDataByAutocomplete')->name('get-data-by-autocomplete');
   /*  Fund  Raiser */

   /*  Manage Profile */
    Route::get('/manage-profile', 'FundRaiserController@ManageProfile')->name('manage-profile');
    Route::get('/my-fundraiser', 'FundRaiserController@MyFundRaiser')->name('my-fundraiser');
   /*  Manage Profile */

    /* Support Ticket */
    Route::get('/create-ticket', 'TicketController@create')->name('create-ticket');
    Route::post('/save-ticket', 'TicketController@store')->name('save-ticket');
    Route::get('/list-ticket', 'TicketController@index')->name('list-ticket');
    Route::get('/search-ticket', 'TicketController@SearchTicketData')->name('search-ticket-data');
    /* Support Ticket */

    /* Wallet  */
    Route::get('/working-wallet', 'WalletController@index')->name('working-wallet');
    Route::get('/help-wallet',    'WalletController@helpwallet')->name('help-wallet');
    Route::get('/fund-transfer',  'WalletController@fundtransfer')->name('fund-transfer');
    /* Wallet  */

    /* Contribution  */
    Route::post('/contribution-fundraiser', 'ContributionController@store')->name('contribution-fundraiser');
   /* Contribution  */

   Route::post('/getAuthName', 'FundRaiserController@getAuthName')->name('get-auth-name');
});


