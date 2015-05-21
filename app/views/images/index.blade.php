@extends("layouts.application")

@section("content")

@foreach($images as $image)

<div class="col-sm-4 col-md-3 col-lg-3 thumbnail">
    {{HTML::image(Request::root().'/uploads/'.$image->id.'/thumb_'.$image->image, 'image not available',array('role'=>'button','class'=>'lightbox_trigger','href'=>Request::root().'/uploads/'.$image->id.'/'.$image->image))}}
    <div class="caption">
    	<h3 class="text-primary">{{$image->title}}</h3>
    	{{link_to('images/'.$image->id, 'Show', array('class' => 'btn btn-info'))}}
    {{link_to('images/'.$image->id.'/edit', 'Edit', array('class' => 'btn btn-warning'))}}
    {{Form::open(array('route' => array('images.destroy', $image->id), 'method'=>'delete'))}}
    {{Form::submit('Delete', array('class' => 'btn btn-danger', "onclick" => "return confirm('are you sure?')"))}}
    {{Form::close()}}
    </div>
</div>
@endforeach

@stop


