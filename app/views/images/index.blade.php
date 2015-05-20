@extends("layouts.application")

@section("content")

<div id="myModal" class="modal fade">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Title</h4>
                </div>
                <div class="modal-body">
                    <p>working</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">close</button>
                </div>
            </div>
        </div>

@foreach($images as $image)

<div class="col-sm-4 col-md-3 col-lg-3 thumbnail">
    {{HTML::image(Request::root().'/uploads/'.$image->id.'/thumb_'.$image->image, 'image not available',array('data-toggle'=>'modal','role'=>'button','href'=>'#myModal'))}}
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


