@extends("layouts.application")

@section("content")

{{Form::model($image, array('route'=> array('images.update', $image->id),'method'=>'PUT','class'=>'form-horizontal','role'=>'form'))}}
	
	<div class="form-group">
		{{Form::open(array('url'=>'images', 'class' => 'form-horizontal', 'role'=>'form', 'files'=>true))}}
		{{Form::text('title','',array('placeholder'=>'Please insert your title here'))}}
		{{Form::file('image')}}
		{{Form::submit('save', array('class'=>'btn btn-primary', 'name'=>'send'))}}
		{{Form::close()}}
		<div class="clear"></div>
	</div>
{{Form::close()}}

@stop