<?php
/*
Project Name: laravelcommerce
Project URI: http://192.168.1.101
Author: VectorCoder Team
Author URI: http://vectorcoder.com/
Version: 1.1 -desktop
*/
header("Cache-Control: no-cache, must-revalidate");
header('Access-Control-Allow-Origin:  *');
header('Access-Control-Allow-Methods:  POST, GET, OPTIONS, PUT, DELETE');
header('Access-Control-Allow-Headers:  Content-Type, X-Auth-Token, Origin, Authorization');



Route::get('/clear-cache', function() {
	$exitCode = Artisan::call('cache:clear');
});

Route::group(['prefix' => 'admin'], function () {

	
	Route::group(['namespace' => 'Admin'], function () {

		Route::group(['middleware' => 'admin'], function () { 

			Route::get('/dashboard', 'AdminController@dashboard');
			Route::get('/post', 'AdminController@myPost');
			Route::get('/adminInfo', 'AdminController@adminInfo');

				//main categories
			Route::get('/categories', 'AdminCategoriesController@categories');
			Route::get('/addcategory', 'AdminCategoriesController@addcategory');
			Route::post('/addnewcategory', 'AdminCategoriesController@addnewcategory');
			Route::get('/editcategory/{id}', 'AdminCategoriesController@editcategory');
			Route::get('/setting', 'AdminController@setting');
			Route::get('/updatesetting', 'AdminController@updatesetting');
			Route::post('/updatesetting', 'AdminController@updatesetting');
			
			Route::post('/updatecategory', 'AdminCategoriesController@updatecategory');
			Route::get('/deletecategory/{id}', 'AdminCategoriesController@deletecategory');

			//sub categories
			Route::get('/subcategories', 'AdminCategoriesController@subcategories');
			Route::get('/addsubcategory', 'AdminCategoriesController@addsubcategory');
			Route::post('/addnewsubcategory', 'AdminCategoriesController@addnewsubcategory');
			Route::get('/editsubcategory/{id}', 'AdminCategoriesController@editsubcategory');
			Route::post('/updatesubcategory', 'AdminCategoriesController@updatesubcategory');
			Route::get('/deletesubcategory/{id}', 'AdminCategoriesController@deletesubcategory');
			
			Route::post('/getajaxcategories', 'AdminCategoriesController@getajaxcategories');

			Route::get('/profile', 'AdminController@adminProfile');
			Route::post('/updateProfile', 'AdminController@updateProfile');
			Route::post('/updateAdminPassword', 'AdminController@updateAdminPassword');
			
			Route::get('/user', 'UsersController@index');			
			Route::resource('/users', 'UsersController');
			Route::post('users/alldelete','UsersController@alldelete');
			Route::get('users/userexist','UsersController@userexist');

			
			Route::resource('/showRoomAdmin', 'showRoomAdminController');
			Route::get('showRoomAdmin/alldelete','showRoomAdminController@alldelete');
			Route::post('showRoomAdmin/updateAdminPassword/{id}', 'showRoomAdminController@updateAdminPassword');
			Route::post('showRoomAdmin/updateShowRoomAdmin/{id}', 'showRoomAdminController@updateShowRoomAdmin');
			Route::post('companyAdmin/store', 'CompanyController@store');
			Route::post('showRoomAdmin/alldelete','showRoomAdminController@alldelete');
			Route::post('showRoomAdmin/zones','showRoomAdminController@zones');
			Route::get('showRoomAdmin/userexist','showRoomAdminController@userexist');

		    Route::resource('/StoreAdmin', 'storeAdminController');
			Route::get('StoreAdmin/alldelete','storeAdminController@alldelete');
			Route::post('StoreAdmin/updateAdminPassword/{id}', 'storeAdminController@updateAdminPassword');
			Route::post('StoreAdmin/updateShowRoomAdmin/{id}', 'storeAdminController@updateShowRoomAdmin');
			Route::post('StoreAdmin/alldelete','storeAdminController@alldelete');
			Route::post('StoreAdmin/zones','storeAdminController@zones');
			Route::get('StoreAdmin/userexist','storeAdminController@userexist');

			Route::resource('/companyAdmin', 'CompanyController');
			Route::get('companyAdmin/alldelete','CompanyController@alldelete');
			Route::post('companyAdmin/updateAdminPassword/{id}', 'CompanyController@updateAdminPassword');
			Route::post('companyAdmin/updateShowRoomAdmin/{id}', 'CompanyController@updateShowRoomAdmin');
			Route::post('companyAdmin/alldelete','CompanyController@alldelete');
			Route::post('companyAdmin/zones','CompanyController@zones');
			Route::get('companyAdmin/userexist','CompanyController@userexist');

			Route::get('orderlist','OrderController@orderList')->name('admin.orderlist');
			Route::get('orderdetail/{id}','OrderController@orderDetail')->name('admin.orderdetail');			
			Route::get('ordereditstatus/{id}','OrderController@statusEdit')->name('admin.ordereditstatus');			
			Route::post('orderlist/allposts','OrderController@allposts')->name('admin.orderlist.allposts');

			Route::get('/property', 'PropertyController@index');
			Route::resource('/property', 'PropertyController');
			Route::post('property/allposts','PropertyController@allposts');
			Route::post('property/propertymultidelete','PropertyController@propertymultidelete');
			Route::post('property/delete_img','PropertyController@delete_img');

			Route::get('/carBrand', 'CarBrandController@index');

			Route::resource('/carBrand', 'CarBrandController');
			Route::get('carBrand/edit/{id}','CarBrandController@edit');
			Route::post('carBrand/allposts','CarBrandController@allposts');
			Route::post('carBrand/update/{id}','CarBrandController@update');
			Route::post('carBrand/alldelete','CarBrandController@alldelete');
			Route::post('carBrand/delete_img','CarBrandController@delete_img');
		


			Route::resource('/property_type', 'PropertyTypeController');
			Route::get('property_type','PropertyTypeController@index');
			Route::post('property_type/allposts','PropertyTypeController@allposts');
			Route::get('property_type/create','PropertyTypeController@create');
			Route::post('property_type/save','PropertyTypeController@save');
			Route::get('property_type/edit/{id}','PropertyTypeController@edit');
			Route::post('property_type/update_propertyType/{id}','PropertyTypeController@update_propertyType');
			Route::post('property_type/propertyTypealldelete','PropertyTypeController@propertyTypealldelete');


			Route::resource('/category', 'PropertyCategoryController');
			Route::get('category','PropertyCategoryController@index');
			Route::get('category/create','PropertyCategoryController@create');
			Route::post('category/save','PropertyCategoryController@save');
			Route::post('category/allposts','PropertyCategoryController@allposts');
			Route::get('category/edit/{id}','PropertyCategoryController@edit');
			Route::post('category/update_propertyCategory/{id}','PropertyCategoryController@update_propertyCategory');
			Route::post('category/propertyCategoryalldelete','PropertyCategoryController@propertyCategoryalldelete');

			Route::resource('/specification', 'SpecificationController');
			Route::get('specification','SpecificationController@index')->name('admin.specification');
			Route::get('specification/create','SpecificationController@create')->name('admin.specification.create');
			Route::post('specification/save','SpecificationController@save')->name('admin.specification.save');
			Route::post('specification/allposts','SpecificationController@allposts')->name('admin.specification.allposts');
			Route::get('specification/edit/{id}','SpecificationController@edit');
			Route::post('specification/update/{id}','SpecificationController@update')->name('admin.specification.update');
			Route::post('specification/alldelete','SpecificationController@alldelete')->name('admin.specification.alldelete');

			Route::resource('/fueltype', 'FuelTypeController');
			Route::get('fueltype','FuelTypeController@index')->name('admin.fueltype');
			Route::get('fueltype/create','FuelTypeController@create')->name('admin.fueltype.create');
			Route::post('fueltype/save','FuelTypeController@save')->name('admin.fueltype.save');
			Route::post('fueltype/allposts','FuelTypeController@allposts')->name('admin.fueltype.allposts');
			Route::get('fueltype/edit/{id}','FuelTypeController@edit');
			Route::post('fueltype/update/{id}','FuelTypeController@update')->name('admin.fueltype.update');
			Route::post('fueltype/alldelete','FuelTypeController@alldelete')->name('admin.fueltype.alldelete');


			Route::resource('/procategory', 'ProCategoryController');
			Route::get('procategory','ProCategoryController@index');
			Route::get('procategory/create','ProCategoryController@create');
			Route::post('procategory/save','ProCategoryController@save');
			Route::post('procategory/allposts','ProCategoryController@allposts');
			Route::get('procategory/edit/{id}','ProCategoryController@edit');
			Route::post('procategory/update_propertyCategory/{id}','ProCategoryController@update_propertyCategory');
			Route::post('procategory/propertyCategoryalldelete','ProCategoryController@propertyCategoryalldelete');			

			Route::get('/ads', 'AdsController@index');
			Route::resource('/ads', 'AdsController');
			Route::post('ads/allposts','AdsController@allposts');
			Route::get('ads/edit/{id}','AdsController@edit');
			Route::post('ads/update_ads/{id}','AdsController@update_ads');
			Route::post('ads/alldelete','AdsController@alldelete');
			Route::post('ads/delete_img','AdsController@delete_img');

			Route::get('/topProperty', 'TopPropertyController@index');
			Route::resource('/topProperty', 'TopPropertyController');
			Route::post('topProperty/allposts','TopPropertyController@allposts');
			Route::post('topProperty/getPropertyId','TopPropertyController@getPropertyId');
			Route::post('topProperty/propertymultidelete','TopPropertyController@propertymultidelete');
			Route::post('topProperty/delete_img','TopPropertyController@delete_img');

			Route::get('/car_accessories', 'carAccessoriesController@index');
			Route::resource('/car_accessories', 'carAccessoriesController');
			Route::get('car_accessories/edit/{id}','carAccessoriesController@edit');
			Route::post('car_accessories/allposts','carAccessoriesController@allposts');
			Route::post('car_accessories/getCategory','carAccessoriesController@getCategory');
			Route::post('car_accessories/update/{id}','carAccessoriesController@update');
			Route::post('car_accessories/alldelete','carAccessoriesController@alldelete');
			Route::post('car_accessories/delete_img','carAccessoriesController@delete_img');

			Route::get('/contactAgent', 'contactAgentController@index');
			Route::post('contactAgent/allposts','contactAgentController@allposts');
			

			Route::resource('/pdf_report', 'PdfReportController');
			Route::get('pdf_report','PdfReportController@index');
			Route::get('pdf_report/create','PdfReportController@create');
			Route::post('pdf_report/allposts','PdfReportController@allposts');
			Route::get('pdf_report/edit/{id}','PdfReportController@edit');
			Route::post('pdf_report/update_pdfFile/{id}','PdfReportController@update_pdfFile');

			Route::resource('/city', 'CityController');
			Route::get('city','CityController@index');
			Route::post('city/allposts','CityController@allposts');
			Route::get('city/create','CityController@create');
			Route::post('city/save','CityController@save');
			Route::get('city/edit/{id}','CityController@edit');
			Route::post('city/update_city/{id}','CityController@update_city');
			Route::post('city/cityalldelete','CityController@cityalldelete');

			Route::get('about/create','AboutController@create');
			Route::post('about/save','AboutController@save');

			Route::resource('/homeslide', 'HomeslideController');
			Route::get('homeslide','HomeslideController@index');
			Route::post('homeslide/allposts','HomeslideController@allposts');
			Route::get('homeslide/create','HomeslideController@create');
			Route::post('homeslide/save','HomeslideController@save');
			Route::get('homeslide/edit/{id}','HomeslideController@edit');
			Route::post('homeslide/update_homeslide/{id}','HomeslideController@update_homeslide');
			Route::post('homeslide/homeslidealldelete','HomeslideController@homeslidealldelete');


/*
			Route::resource('/company', 'CompanyController');
			Route::get('company','CompanyController@index');
			Route::post('company/allposts','CompanyController@allposts');
			Route::get('company/create','CompanyController@create');
			Route::post('company/save','CompanyController@save');
			Route::get('company/edit/{id}','CompanyController@edit');
			Route::post('company/update_city/{id}','CompanyController@update_city');
			Route::post('company/cityalldelete','CompanyController@cityalldelete');*/


		});

		
		//log in
		Route::get('/login', 'AdminController@login')->name('login');
		Route::get('/', 'AdminController@login');
		Route::post('/checkLogin', 'AdminController@checkLogin');

		Route::post('/users/allsearch', array(
  			'uses' => 'UsersController@allposts'
		));

		Route::post('/showRoomAdmin/allsearch', array(
  			'uses' => 'showRoomAdminController@allposts'
		));


		Route::post('/StoreAdmin/allsearch', array(
  			'uses' => 'storeAdminController@allposts'
		));

		Route::post('/property/allsearch', array(
  			'uses' => 'PropertyController@allposts'
		));	

			Route::post('/companyAdmin/allsearch', array(
  			'uses' => 'CompanyController@allposts'
		));	

		//log out
		Route::get('/logout', 'AdminController@logout');
});

});



Theme::set('themeone');

Route::group(['namespace' => 'Web'], function () {	
	
	

	Route::get('/', 'HomeController@index');
	Route::get('/categoryFilter','HomeController@categoryFilter')->name('category.filter');

	Route::get('/register', 'RegisterController@index');
	Route::post('/insertuser', 'RegisterController@insertuser');
	Route::get('/login', 'RegisterController@login')->name('login');
	Route::post('/checkuserLogin', 'RegisterController@checkuserLogin');
	Route::get('/userlogout', 'RegisterController@logout');
	Route::get('/profile', 'RegisterController@profile');
	Route::post('/updateprofile', 'RegisterController@updateprofile');
	Route::post('/edituserimage', 'RegisterController@edituserimage');
	Route::post('/changePassword', 'RegisterController@changePassword');

	Route::get('/changelang/{text}', 'HomeController@changelang');

	Route::get('/car_listing', 'CarsController@index');
	Route::post('/car_listing/load_data', 'CarsController@load_data');
	Route::get('/car_detail/{id}', 'CarsController@car_detail');
	Route::post('/search', 'CarsController@search');
	Route::post('/carResult', 'DefaultController@carResult');
	Route::post('/load_data', 'DefaultController@load_data');
	Route::post('/storeResult', 'CarsController@storeResult');

	Route::get('/myCar', 'CarsController@myCar');
	Route::post('/useraddCar', 'CarsController@useraddCar');
	Route::get('/myCar_edit/{id}', 'CarsController@myCar_edit');
	Route::post('/myCar_edit/delete_img', 'CarsController@delete_img');

	Route::get('/showroomlist/{filter?}','DefaultController@showroomList');
	Route::get('/carshowroom_detail/{id}', 'DefaultController@carshowroom_detail');
	Route::get('/contactus','DefaultController@contactus');
	Route::get('/rentalcar_detail/{id}', 'DefaultController@rentalcar_detail');
	
	Route::get('/storeadminlist','CarsController@storeAdminList')->name('storeadminlist');
	Route::get('/companyadminlist/{filter?}','DefaultController@companyAdminList');
	Route::get('/productlist/{id}','CarsController@productList')->name('productlist');
	Route::get('/companyPropertyList/{id}','DefaultController@companyPropertyList')->name('companypropertylist');
	Route::post('/companyPropertyList/contactAgent','DefaultController@contactAgentSave')->name('companypropertylist.contectagent.save');
	Route::get('/contactAgentImage/delete', 'DefaultController@rentalcarImageDelete')->name('contactAgentImage.delete');
	Route::get('/showroomPropertyList/{id}','DefaultController@showroomPropertyList');
	Route::post('/contactstore', 'DefaultController@contactstore');

	
	// Route::get('/showroomlist','DefaultController@showroomList');
	Route::get('/sell-list/sell-list', 'DefaultController@sellList');
	Route::get('/sell-list','DefaultController@sellList');
	Route::get('/sell-detail/{id}','DefaultController@sellDetail');
	Route::get('/addnewcart/{id}','AddToCartController@addNewCart')->name('addnewcart');
	Route::get('/deletecart/{id}','AddToCartController@deleteCart')->name('deletecart');
	Route::get('/updatecart/{id}','AddToCartController@updateCart')->name('updatecart');
	Route::get('/buynow/form','BuyNowController@addCart')->name('buynow.form');
	Route::post('/buynow/save','BuyNowController@saveCart')->name('buynow.save');
	Route::get('/order/list','BuyNowController@orderList')->name('order.list');
	Route::get('/order/detail/{id}','BuyNowController@orderDetail')->name('order.detail');	


	Route::get('/car_Detail/{id}','DefaultController@car_Detail');	




	Route::get('/showcart', function () {
    	//return resource_path('views');
    	return view('cartshow');
	})->name('showcart');
	Route::get('/success', function () {
    	//return resource_path('views');
    	return view('success');
	});

	Route::get('/ForgotPassword/',function(){
		return view('error_page');
	});

	Route::get('/ForgotPassword/{id}','ForgotPasswordController@create');
	Route::post('/ForgotPassword/save','ForgotPasswordController@save');

	Route::post('/api/applogin','WebserviceController@applogin');
	Route::post('/api/passwordForgot','WebserviceController@passwordForgot');
	Route::post('/api/allCarList','WebserviceController@allCarList');
	Route::post('/api/userCarList','WebserviceController@userCarList');
	Route::post('/api/adminCarList','WebserviceController@adminCarList');
	Route::post('/api/adminShowroomList','WebserviceController@adminShowroomList');
	Route::post('/api/carDetail','WebserviceController@carDetail');
	Route::post('/api/registration','WebserviceController@registration');
	Route::post('/api/chnagePassword','WebserviceController@chnagePassword');
	Route::post('/api/editProfile','WebserviceController@editProfile');
	Route::post('/api/addCar','WebserviceController@addCar');
	Route::post('/api/carDelete','WebserviceController@carDelete');
	Route::post('/api/allModelList','WebserviceController@allModelList');
	Route::post('/api/allTypeList','WebserviceController@allTypeList');
	Route::post('/api/carPublished','WebserviceController@carPublished');
	Route::post('/api/requestCar','WebserviceController@requestCar');
	Route::post('/api/allProductList','WebserviceController@allProductList');
	Route::post('/api/storeProductList','WebserviceController@storeProductList');
	Route::post('/api/storeList','WebserviceController@storeList');
	Route::post('/api/productDetail','WebserviceController@productDetail');
	Route::post('/api/contactAgent','WebserviceController@contactAgent');
	Route::post('/api/getCity','WebserviceController@getCity');
	Route::post('/api/appdeleteCarImage','WebserviceController@appdeleteCarImage');
	Route::post('/api/getCompanyRental','WebserviceController@getCompanyRental');
	Route::post('/api/getCompanySell','WebserviceController@getCompanySell');
	Route::post('/api/getcompanyCity','WebserviceController@getcompanyCity');
	Route::post('/api/carBooking','WebserviceController@carBooking');
	Route::post('/api/placeOrder','WebserviceController@placeOrder');
	Route::post('/api/orderListing','WebserviceController@orderListing');	

	Route::post('/api/allSpecificationList','WebserviceController@allSpecificationList');
	Route::post('/api/allfuelList','WebserviceController@allfuelList');	
	Route::post('/api/allBrandList','WebserviceController@allBrandList');	



	
	Route::get('/clear-cache', function() {
		$exitCode = Artisan::call('cache:clear');
	});
		
	
});
