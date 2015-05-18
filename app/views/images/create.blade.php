@extends("layouts.application")

@section("content")

	{{Form::open(array('url'=>'images', 'class' => 'form-horizontal', 'role'=>'form', 'files'=>true))}}
	<div class="form-group">
		<label for="title" class="col-sm-2 control-label">Title</label>
		<div class="col-sm-10">
			{{Form::text('title','',array('placeholder'=>'Please insert your title here','id'=>'title','class'=>'form-control'))}}	
		</div>		
	</div>
	<div class="form-group">
		<label for="image" class="col-sm-2 control-label">Image</label>
		<div class="col-sm-10">
			{{Form::file('image')}}		
		</div>
	</div>
	<div class="form-group">
		<div class="col-sm-10">
			{{Form::submit('save', array('class'=>'btn btn-primary', 'name'=>'send'))}}		
		</div>
	</div>	
	{{Form::close()}}

@stop