<?php

class ImagesController extends \BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
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
    public function create() {
        //
        return View::make('images.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store() {
        //
        $validate = Validator::make(Input::all(), Images::$upload_rules);
        if ($validate->fails()) {
            return Redirect::to('images/create')
                            ->withErrors($validate)
                            ->withInput();
        } else {
            //if validation success, upload the image to the database and process it
            $image = Input::file('image');

            //This is the original uploaded client name of the image
            $filename = $image->getClientOriginalName();
            $filename = pathinfo($filename, PATHINFO_FILENAME);

            //randomize filename
            $fullname = Str::slug(Str::random(8) . $filename) . '.' . $image->getClientOriginalExtension();



            //check if image was inputted
            if ($image) {
                //image will be uploaded, add column first to the database
                $insert = new Images;
                $insert->title = Input::get('title');
                $insert->image = $fullname;
                $insert->save();
                $id = $insert->id;

                //create directory for uploaded images
                $directory = public_path() . '/uploads/' . $id . '/';
                $existDir = File::isDirectory($directory);
                if (!$existDir) {
                    File::makeDirectory($directory, 0775, true);
                }
                //upload the image first to the upload folder identified by $id
                $image->move($directory, $fullname);
                $thumb = 'thumb_' . $fullname;

                //these parameters are related to the image processing class using intervention
                Image::make($directory . $fullname)
                        ->resize(null, 200, function($constraint){
                            $constraint->aspectRatio();
                        })
                        ->save($directory . $thumb);

                return Redirect::to('images/show/' . $insert->id)
                                ->with('success', 'Your image is uploaded successfuly!');
            } else {
                //image cannot be uploaded
                return Redirect::to('/')
                                ->withInput()
                                ->with('error', 'Sorry the image could not be uploaded, please try again later');
            }

            //$image = new Image;
            $image->title = Input::get('title');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id) {
        //take all images with a pagination feature
        $image = Images::find($id);
        $directory = '/uploads/' . $id . '/';

        //load the view with found data and pass the variable to the view
        if ($image) {
            return View::make('images.show')->with('image', $image)->with('directory', $directory);
        } else {
            return Redirect::to('images.index')->with('error', 'Image not found');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {
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
    public function update($id) {
        //
        //find image in databases
        $file = Input::file('image');
        $db_image = Images::find($id);
        if (is_null($file)) {
            $image = new Symfony\Component\HttpFoundation\File\File(public_path() . '/uploads/' . $id . '/' . $db_image->image);
            $token = false;
            //$mime = $image->getMimeType();
        } else {
            $image = Input::file('image');
            $token = true;
            File::cleanDirectory(public_path() . '/uploads/' . $id . '/');
        }

        $validate = Validator::make(
                        array(
                    'title' => Input::get('title'),
                    'image' => $image
                        ), array(
                    'title' => 'required|min:3',
                    'image' => 'required|mimes:jpeg,jpg,bmp,png'
                        )
        );

        if ($validate->fails()) {
            return Redirect::to('images/' . $id . '/edit')
                            ->withErrors($validate)
                            ->withInput();
        } else {
            //if validation success, upload the image to the database and process it
            //$image = Input::file('image');
            //if new images uploaded
            if ($token) {
                //This is the original uploaded client name of the image
                $filename = $image->getClientOriginalName();
                $filename = pathinfo($filename, PATHINFO_FILENAME);

                //randomize filename
                $fullname = Str::slug(Str::random(8) . $filename) . '.' . $image->getClientOriginalExtension();
            }

            //check if image was inputted
            if ($image) {
                //image will be uploaded, add column first to the database
                $db_image->title = Input::get('title');
                if ($token) {
                    $db_image->image = $fullname;
                }
                $db_image->save();
                $id = $db_image->id;

                //create directory for  new uploaded images

                $directory = public_path() . '/uploads/' . $id . '/';
                $existDir = File::isDirectory($directory);
                if (!$existDir) {
                    File::makeDirectory($directory, 0775, true);
                }
                //upload the image first to the upload folder identified by $id
                if ($token) {
                    $image->move($directory, $fullname);
                    $thumb = 'thumb_' . $fullname;
                    //these parameters are related to the image processing class using intervention
                    Image::make($directory . $fullname)
                            ->resize(100, 200)
                            ->save($directory . $thumb);
                }

                return Redirect::to('images/show/' . $db_image->id)
                                ->with('success', 'Your image is updated successfuly!');
            } else {
                //image cannot be uploaded
                return Redirect::to('/')
                                ->withInput()
                                ->with('error', 'Sorry the image could not be uploaded, please try again later');
            }

            //$image = new Image;
            $image->title = Input::get('title');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        //find the image by id
        $image = Images::find($id);
        $directory = public_path() . '/uploads/' . $id . '/';

        //if there's an image, continue with deleting process
        if ($image) {
            //delete first the image from upload folder
            File::deleteDirectory($directory);

            //delete the value from database
            $image->delete();

            //return to the main page with a success message
            return Redirect::to('images')
                            ->with('success', 'Image deleted successfully');
        } else {
            //Image not found, redirect to the index page with an error message
            return Redirect::to('images')
                            ->with('error', 'No image with given ID found');
        }
    }

}
