@extends("layouts.application")

@section("content")
	
	<div>{{link_to('images/create', 'Upload Images', array('class' => 'btn btn-success'))}}</div>

	@foreach($images as $image)
		<article class="white-panel">
			{{HTML::image(Config::get('image.thumb_folder').'/'.$image->image)}}
				<h1><a href="#">{{$image->title}}</a></h1>
				{{link_to('images/'.$image->id, 'Show', array('class' => 'btn btn-info'))}}
				{{link_to('images/'.$image->id.'/edit', 'Edit', array('class' => 'btn btn-warning'))}}
				{{Form::open(array('route' => array('images.destroy', $images->id), 'method'=>'delete'))}}
				{{Form::submit('Delete', array('class' => 'btn btn-danger', "onclick" => "return confirm('are you sure?')"))}}
				{{Form::close()}}
		</article>
	@endforeach
@stop

		
