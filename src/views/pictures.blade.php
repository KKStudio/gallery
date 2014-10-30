@extends('admin.template')

@section('content')

	<h3 class="pull-left">Pictures</h3>

	<h4>{{ $album->name }}</h4>

	<hr>

	<div class=""> 

		{!! Form::open([ 'url' => 'admin/gallery/' . $album->slug . '/pictures', 'files' => 'true']) !!}

			{!! Form::submit('Add pictures', [ 'class' => 'btn btn-lg btn-primary pull-right']) !!}

			<div class="clearfix"></div>

			<div class="fileinput fileinput-new" data-provides="fileinput">
			  <div class="fileinput-new thumbnail" style="width: 150px; height: 150px;">
			  	
			  </div>
			  <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"></div>
			  <div>
			    <span class="btn btn-default btn-file">
				    <span class="fileinput-new">Select image</span>
				    <span class="fileinput-exists">Change</span>		    
				    {!! Form::file('images[]', [ 'class' => 'form-control', 'multiple' => true]) !!}
				    </span>
			    <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
			  </div>
			</div>

		{!! Form::close() !!}

	</div>

	<hr>

	<div class="row">

	@foreach($album->pictures as $k => $picture)

		<div class="col-xs-6 col-sm-4 col-md-3">

			<img src="{{ $picture->getThumb() }}" class="img-thumbnail">

		</div>

	@endforeach

	</div>

@stop