@extends('admin.template')

@section('content')

	<h3 class="pull-left">Usuń album</h3>

	<div class=""> 

		{!! Form::open([ 'url' => 'admin/gallery/' . $album->id . '/delete']) !!}

			{!! Form::submit('Potwierdź usunięcie', [ 'class' => 'btn btn-lg btn-danger pull-right']) !!}

			<div class="clearfix"></div>

			<p>Potwierdź usunięcie albumu <b>{{ $album->name }}</b> klikając w przycisk powyżej.</p>

		{!! Form::close() !!}

	</div>

@stop