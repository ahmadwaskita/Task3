<?php

class ImagesController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
		$images = Images::all();
		return View::make('images.index')
			->with('images', $images);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
		return View::make('images.create');
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
		$validate = Validator::make(Input::all(), Images::$upload_rules);
		if($validate->fails()){
			return Redirect::to('images/create')
				->withErrors($validate)
				->withInput();
		} else {
			//if validation success, upload the image to the database and process it
			$image = Input::file('image');

			//This is the original uploaded client name of the image
			$filename = $image->getClientOriginalName();
			$filename = pathinfo($filename, PATHINFO_FILENAME);

			//salt and make an url-friendly version of the file name
			$fullname = Str::slug(Str::random(8).$filename).'.'.$image->getClientOriginalExtension();

			//upload the image first to the upload folder, then make a thumbnail from the uploaded image
			$upload = $image->move(Config::get('image.db_upload_folder'), $fullname);

			//these parameters are related to the image processing class using intervention
			Image::make(Config::get('image.db_upload_folder').'/'.$fullname)
				->resize(Config::get('image.thumb_width','image.thumb_height'))
				->save(Config::get('image.db_thumb_folder').'/'.$fullname);

			//if the file is not uploaded, show an error message. Else, add a new column to the database and show the success message
				if($upload){
					//image will be uploaded, add column first to the database
					$insert = new Images;
					$insert->title = Input::get('title');
					$insert->image = $fullname;
					$insert->save();
					return Redirect::to('images/show/'.$insert->id)
						->with('success', 'Your image is uploaded successfuly!');
				} else {
					//image cannot be uploaded
					return Redirect::to('/')
						->withInput()
						->with('error', 'Sorry the image could not be uploaded, please try again later');
				}

			//$image = new Image;
			//$image->title = Input::get('title');

		}
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//take all images with a pagination feature
		$image = Images::find($id);

		//load the view with found data and pass the variable to the view
		if($image){
			return View::make('images.show')->with('image', $image);
		} else {
			return Redirect::to('images.index')->with('error','Image not found');
		}
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
		$images = Images::find($id);
		return View::make('images.edit')
			->with('image', $images);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
		$validate = Validator::make(Input::all(), Images::$upload_rules);
		if($validate->fails()){
			return Redirect::to('images/'.$id.'/edit')
				->withErrors($validate)
				->withInput();
		} else {
			//if validation success, upload the image to the database and process it
			$temp = Images::find($id);
                        File::delete(Config::get('image.db_thumb_folder').'/'.$temp->image);
                        $image = Input::file('image');

			//This is the original uploaded client name of the image
			$filename = $image->getClientOriginalName();
			$filename = pathinfo($filename, PATHINFO_FILENAME);

			//salt and make an url-friendly version of the file name
			$fullname = Str::slug(Str::random(8).$filename).'.'.$image->getClientOriginalExtension();

			//upload the image first to the upload folder, then make a thumbnail from the uploaded image
			$upload = $image->move(Config::get('image.upload_folder'), $fullname);

			//these parameters are related to the image processing class using intervention
			Image::make(Config::get('image.upload_folder').'/'.$fullname)
				->resize(Config::get('image.thumb_width','image.thumb_height'))
				->save(Config::get('image.thumb_folder').'/'.$fullname);

			//if the file is not uploaded, show an error message. Else, add a new column to the database and show the success message
				if($upload){
					//image will be uploaded, add column first to the database
					$insert = Images::find($id);
					$insert->title = Input::get('title');
					$insert->image = $fullname;
					$insert->save();
					return Redirect::to('images.show')
						->with('success', 'Your image is updated successfuly!');
				} else {
					//image cannot be uploaded
					return Redirect::to('images')
						->withInput()
						->with('error', 'Sorry the image could not be uploaded, please try again later');
				}

			//$image = new Image;
			//$image->title = Input::get('title');

		}
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//find the image by id
		$image = Images::find($id);

		//if there's an image, continue with deleting process
		if($image){
			//delete first the image from FTP
			File::delete(Config::get('image.upload_folder').'/'.$image->image);
			File::delete(Config::get('image.thumb_folder').'/'.$image->image);

			//delete the value from database
			$image->delete();

			//return to the main page with a success message
			return Redirect::to('images.index')
			 	->with('success', 'Image deleted successfully');
		} else {
			//Image not found, redirect to the index page with an error message
			return Redirect::to('images.index')
				->with('error', 'No image with given ID found');
		}
	}


}
