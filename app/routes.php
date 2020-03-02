<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
    return Redirect::to('/transaksi');
});

Route::get('/user/login', array('before' => 'authToken | guest', function()
{
    if(Auth::check())
    {
        return Redirect::to('/transaksi');
    }
    
    return View::make('login');
}));

Route::post('/user/login', 'UserController@validateUser');
Route::get('/user/authtoken', array('before' => 'guest', function()
{
    if(Auth::check())
    {
        return Redirect::to('/transaksi');
    }
    
    return View::make('authtoken');
}));

Route::post('/user/authtoken', 'UserController@validateAuthToken');
Route::get('/user/logout', array('before' => 'auth', function()
{
    if(Auth::check())
    {
        Auth::logout();
    }
    
    return Redirect::to('/user/login');
}));

Route::post('/user/ajaxChangePassword', array(
    'before' => 'auth|ajax',
    'uses' => 'UserController@ajaxChangePassword'
));

Route::post('/user/ajaxUpdateTimer', array(
    'before' => 'auth|ajax',
    'uses' => 'UserController@ajaxUpdateTimer'
));

Route::post('/user/ajaxUpdateProfile', array(
    'before' => 'auth|ajax',
    'uses' => 'UserController@ajaxUpdateProfile'
));

Route::get('/transaksi', array(
    'before' => 'auth', 
    'uses' => 'TransaksiController@index'
));

Route::post('/transaksi', array(
    'before' => 'auth', 
    'uses' => 'TransaksiController@transactionList'
));

Route::get('/transaksi/ajaxDoInquiry', array(
    'before' => 'auth|ajax',
    'uses' => 'TransaksiController@ajaxDoInquiry'
));

Route::get('/transaksi/ajaxDoTestPrint', array(
    'before' => 'auth', 
    'uses' => 'TransaksiController@ajaxDoTestPrint'
));

Route::get('/transaksi/ajaxDoCollectiveInquiry', array(
   'before' => 'auth',
   'uses' => 'TransaksiController@ajaxDoCollectiveInquiry'
));

Route::get('/transaksi/ajaxDoPurchase', array(
    'before' => 'auth|ajax',
    'uses' => 'TransaksiController@ajaxDoPurchase'
));

Route::get('/transaksi/ajaxDoPostingPayment', array(
    'before' => 'auth',
    'uses' => 'TransaksiController@ajaxDoPostingPayment'
));

Route::get('/transaksi/generateTelcoStruk', array(
    'before' => 'auth',
    'uses' => 'TransaksiController@generateTelcoStruk'
));

Route::get('/product/ajaxGetAllPostPaidProducts', array(
    'before' => 'auth',
    'uses' => 'ProductController@ajaxGetAllPostPaidProducts'
));

Route::get('/product/ajaxGetAllPrePaidProducts', array(
    'before' => 'auth|ajax',
    'uses' => 'ProductController@ajaxGetAllPrePaidProducts'
));

Route::get('/product/ajaxGetSubProducts', array(
    'before' => 'auth|ajax',
    'uses' => 'ProductController@ajaxGetSubProducts'
));

Route::get('/struk/{file}', function($filename = NULL)
{
    if($filename != NULL)
    {
        $filepath = public_path('struk/' . $filename);
        return File::get($filepath);
    }
});

Route::get('/deposit/ajaxGetDepositHistory', array(
    'before' => 'auth|ajax',
    'uses' => 'DepositController@ajaxGetDepositHistory'
));

Route::get('/report/ajaxGetMonthlyReport', array(
    'before' => 'auth|ajax',
    'uses' => 'ReportController@ajaxGetMonthlyReport'
));

Route::get('/report/ajaxGetDailyReport', array(
    'before' => 'auth|ajax',
    'uses' => 'ReportController@ajaxGetDailyReport'
));
