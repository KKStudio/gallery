@extends('admin.template')

@section('content')

	<h3 class="pull-left">Delete album</h3>

	<div class=""> 

		{!! Form::open([ 'url' => 'admin/gallery/' . $album->id . '/delete']) !!}

			{!! Form::submit('Delete album', [ 'class' => 'btn btn-lg btn-danger pull-right']) !!}

			<div class="clearfix"></div>

			<p>Confirm deleting album <b>{{ $album->name }}</b> by clicking the button above.</p>

		{!! Form::close() !!}

	</div>

@stop