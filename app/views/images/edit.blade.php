@extends("layouts.application")

@section("content")

{{Form::model($image, array('route'=> array('images.update', $image->id),'files'=>true,'method'=>'PUT','class'=>'form-horizontal','role'=>'form'))}}
	
	<div class="form-group">
		<label for="title" class="col-sm-5 control-label">New Title</label>
		<div class="col-sm-10">
			{{Form::text('title',$image->title,array('id'=>'title','class'=>'form-control'))}}	
		</div>		
	</div>
	<div class="form-group">
		<p></p>
		{{HTML::image(Request::root().'/uploads/'.$image->id.'/'.$image->image)}}
		<p></p>
		<label for="image" class="col-sm-7 control-label">New Image</label>
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