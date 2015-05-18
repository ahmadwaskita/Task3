<?php

class Images extends \Eloquent {
	protected $table = 'images';

	protected $fillable = ['title','image'];

	public static $upload_rules = array(
		'title' => 'required|min:3',
		'image'	=> 'required|mimes:jpg,jpeg,bmp,png'
	);
}