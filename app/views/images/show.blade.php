@extends("layouts.application")

@section("content")
	<div>
	<article class="white-panel">
		{{HTML::image(Config::get('image.thumb_folder').'/'.$image->image)}}
			<h1><a href="#">{{$image->title}}</a></h1>
	</article>
	</div>
@stop