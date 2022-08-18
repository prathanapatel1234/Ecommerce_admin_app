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

Route::get('/admin/franchise-list', 'Backend\SiteAuthController@getFranchiseData')->name('franchise-list')->middleware(['permission:Fund Raiser List']);
Route::get('/admin/viewdetail/{id}', 'Backend\SiteAuthController@viewDetail')->name('view-details')->middleware(['permission:Banner Edit']);
// Route::get('/admin/franchise-list', 'Backend\SiteAuthController@getPDF');

Route::group(['middleware' => ['auth'], 'namespace' => 'Backend'], function() {

    Route::get('/admin/dashboard', 'DashboardController@index')->name('admin.dashboard');
    Route::get('/admin/get-all-notification', 'DashboardController@getAllNotification');

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
        Route::get('/admin/users/enquiry-list', 'UserController@enquirylist')->name('enquiry-list')->middleware(['permission:User View']);

    });

    //Banner Master
    Route::group(['middleware' => ['permission:Banner Master']], function() {
        Route::get('/admin/banner-list', 'BannerController@index')->name('banner-list')->middleware(['permission:Banner List']);
        Route::get('/admin/banner/create', 'BannerController@create')->name('banner-create')->middleware(['permission:Banner Create']);
        Route::post('/admin/banner/store', 'BannerController@store')->name('banner-store')->middleware(['permission:Banner Create']);
        Route::get('/admin/banner/edit/{id}', 'BannerController@edit')->name('banner-edit')->middleware(['permission:Banner Edit']);
        Route::post('/admin/banner/update/{id}', 'BannerController@update')->name('banner-update')->middleware(['permission:Banner Edit']);
        Route::get('/admin/banner/delete/{id}', 'BannerController@destroy')->name('banner-delete')->middleware(['permission:Banner Delete']);
        Route::post('/admin/banner/export-search-results', 'BannerController@export')->name('export-search-results');

    });

    //Pincode Master
    Route::group(['middleware' => ['permission:Banner Master']], function() {
        Route::get('/admin/pincode-list', 'PincodeController@index')->name('pincode-list')->middleware(['permission:Banner List']);
        Route::get('/admin/pincode/create', 'PincodeController@create')->name('pincode-create')->middleware(['permission:Banner Create']);
        Route::post('/admin/pincode/store', 'PincodeController@store')->name('pincode-store')->middleware(['permission:Banner Create']);
        Route::get('/admin/pincode/edit/{id}', 'PincodeController@edit')->name('pincode-edit')->middleware(['permission:Banner Edit']);
        Route::post('/admin/pincode/update/{id}', 'PincodeController@update')->name('pincode-update')->middleware(['permission:Banner Edit']);
        Route::get('/admin/pincode/delete/{id}', 'PincodeController@destroy')->name('pincode-delete')->middleware(['permission:Banner Delete']);
    });

    //Promocode Master
    Route::group(['middleware' => ['permission:Banner Master']], function() {
        Route::get('/admin/promocode-list', 'OfferController@index')->name('offer-list')->middleware(['permission:Banner List']);
        Route::get('/admin/promocode/create', 'OfferController@create')->name('offer-create')->middleware(['permission:Banner Create']);
        Route::post('/admin/promocode/store', 'OfferController@store')->name('offer-store')->middleware(['permission:Banner Create']);
        Route::get('/admin/promocode/edit/{id}', 'OfferController@edit')->name('offer-edit')->middleware(['permission:Banner Edit']);
        Route::post('/admin/promocode/update/{id}', 'OfferController@update')->name('offer-update')->middleware(['permission:Banner Edit']);
        Route::get('/admin/promocode/delete/{id}', 'OfferController@destroy')->name('offer-delete')->middleware(['permission:Banner Delete']);
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
        Route::get('/admin/category/delete/{id}', 'CategoryController@destroy')->name('category-delete')->middleware(['permission:Banner Delete']);

    });

    //Prodcut Master
    Route::group(['middleware' => ['permission:Product Master']], function() {

        Route::get('/admin/product', 'ProductController@index')->name('product-list')->middleware(['permission:Prodcut List']);

        Route::get('/admin/bulk/upload', 'ProductController@bulkUpload')->name('bulk-upload')->middleware(['permission:Prodcut List']);
        
        Route::post('/admin/bulk/product', 'ProductController@importProduct')->name('bulk-product')->middleware(['permission:Prodcut List']);
        
        Route::get('/admin/product/create', 'ProductController@create')->name('product-create')->middleware(['permission:Prodcut Create']);
        Route::post('/admin/product/store', 'ProductController@store')->name('product-save')->middleware(['permission:Prodcut Create']);
        Route::get('/admin/product/edit/{id}', 'ProductController@edit')->name('product-edit')->middleware(['permission:Prodcut Edit']);
        Route::post('/admin/product/update/{id}', 'ProductController@update')->name('product-update')->middleware(['permission:Prodcut Edit']);
        Route::get('/admin/product/get-subcategory', 'ProductController@getSubcategory')->name('get-subcategory')->middleware(['permission:Prodcut Edit']);

        Route::get('/admin/orders/', 'ProductController@OrdersListing')->name('admin.order-list');
        Route::get('/admin/orders-details/{id}', 'ProductController@OrdersDetailListing')->name('admin.order-details');
        Route::post('/admin/orders/update/{id}', 'ProductController@UpdateOrderStatus')->name('update-order-status')->middleware(['permission:Prodcut Create']);
        Route::get('/admin/product/delete/{id}', 'ProductController@destroy')->name('product-delete')->middleware(['permission:Banner Delete']);
        Route::get('/admin/bulk/upload', 'ProductController@bulkUpload')->name('bulk-upload')->middleware(['permission:Prodcut List']);
        Route::get('/admin/bulk/image-upload', 'ProductController@bulkImageUpload')->name('bulkImage-Upload');
        Route::post('/admin/bulk/moveimage-upload', 'ProductController@moveBulkImage')->name('move-bulkimage');


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

Route::group(['namespace' => 'Frontend'], function() {

        Route::get('/currency', 'HomeController@currency')->name('currency');
        Route::get('/', 'HomeController@index')->name('home');
        Route::get('/changevarient', 'HomeController@changevarient')->name('changevarient');
        Route::post('/cart-add', 'CartController@add')->name('cart.add');
        Route::get('/cart-checkout', 'CartController@cart')->name('cart.list');
        Route::get('/remove/{id}', 'CartController@remove')->name('remove');
        Route::post('/cart-update', 'CartController@update')->name('cart.update');
        Route::post('/cart-clear', 'CartController@clear')->name('cart.clear');

        Route::get('/login/', 'HomeController@login')->name('login');
        Route::get('/register/', 'HomeController@register')->name('register');
        Route::post('/save/register', 'HomeController@store')->name('save.register');

        Route::get('/shop/', 'HomeController@ShopPage')->name('shop');
        Route::get('/shop/products', 'HomeController@getProductsByCategory')->name('shop-products');

        Route::get('/categories/{url}', 'HomeController@categories')->name('categories');
        Route::post('/checklogin', 'LoginController@checkLogin')->name('check-login');
        Route::get('/category/{category}', 'HomeController@getCategoryData')->name('category-page');

        Route::get('/category/{category}/{subcategory}', 'HomeController@getSubCategoryData')->name('sub-category-page');

        Route::get('/category/{category}/product/{slug}', 'HomeController@SingleCategoryProductPage')->name('single-category-product');

        Route::get('/category/{category}/{subcategory}/product/{slug}', 'HomeController@getSingleProductData')->name('single-product');

        Route::get('/location/', 'HomeController@setCityForUser')->name('location');

    });

Route::group(['middleware' => ['isLogin'], 'namespace' => 'Frontend'], function() {
    /* Dashboard */
    Route::get('/users/dashboard', 'DashboardController@index')->name('users.dashboard');
    Route::get('/users/my-orders', 'DashboardController@myorders')->name('my.orders');
    Route::get('/users/my-profile', 'DashboardController@myProfile')->name('my.profile');
    Route::post('/users/update-user/{id}', 'DashboardController@UpdateUser')->name('update-user');
    Route::get('/users/order-details/{orderid}', 'DashboardController@OrderDetails')->name('order.details');
    Route::get('pdfview',array('as'=>'pdfview','uses'=>'DashboardController@pdfview'));
    /*Dashboard */

    Route::get('/checkout/', 'CartController@checkout')->name('cart.checkout');
    Route::get('/logout/', 'LoginController@logout')->name('logout');
    /* Fund  Raiser */
    Route::get('/search-data', 'FundRaiserController@SearchData')->name('search-data');
    Route::get('/get-data-by-autocomplete', 'FundRaiserController@GetDataByAutocomplete')->name('get-data-by-autocomplete');
    Route::get('/ajax-notification', 'FundRaiserController@ajaxNotification')->name('ajax-notification');
    Route::get('/ajax-notification-update', 'FundRaiserController@ajaxNotificationUpdate')->name('ajax-notification-update');
   /*  Fund  Raiser */

   /*Payment Routes */
    // Route::get('product', 'PaymentController@index');
    Route::post('paysuccess', 'PaymentController@razorPaySuccess')->name('paysuccess');
    // Route::post('razor-thank-you', 'PaymentController@thankYou');
   /*Payment Routes */
});


