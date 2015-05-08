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
	return View::make('index');
});

Route::resource('images', 'ImagesController');

Route::get('images/show/{id}', array('as'=>'get_image_information','uses'=>'ImagesController@show'))->where('id','[0-9]+');

Route::get('test',function(){
	//mass duplicate all columns
	$images = Images::all();
	foreach($images as $each) {
		Images::create(array(
			'title'	=> $each->title,
			'image'	=> $each->image
		));
	}
});