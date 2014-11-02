@extends('admin.template')

@section('content')

	<h3 class="pull-left">Zdjęcia</h3>

	<div class="clearfix"></div><br>

	<h4>{{ $album->name }}</h4>

	<hr>

	<div class=""> 

		{!! Form::open([ 'url' => 'admin/gallery/' . $album->slug . '/pictures', 'files' => 'true']) !!}

			{!! Form::submit('Dodaj zdjęcia', [ 'class' => 'btn btn-lg btn-primary pull-right']) !!}

			<div class="clearfix"></div>

			<div class="fileinput fileinput-new" data-provides="fileinput">
			  <div class="fileinput-new thumbnail" style="width: 150px; height: auto">
			  	
			  </div>
			  <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"></div>
			  <div>
			    <span class="btn btn-default btn-file">
				    <span class="fileinput-new">Wybierz zdjęcia</span>
				    <span class="fileinput-exists">Zmień</span>		    
				    {!! Form::file('images[]', [ 'class' => 'form-control', 'multiple' => true]) !!}
				    </span>
			    <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Usuń</a>
			  </div>
			</div>

		{!! Form::close() !!}

	</div>

	<hr>

	<div class="row">

	@if(count($album->pictures))

	@foreach($album->pictures as $k => $picture)

		<div class="">

			<img src="{{ $picture->getThumb() }}" class="img-thumbnail pull-left" style="max-width: 320px; max-height: 180px;">

			<div class="controls pull-left"> 

			{!! Form::open(['url' => 'admin/gallery/' . $album->slug . '/pictures/delete' ]) !!}

				{!! Form::hidden('picture_id', $picture->id) !!}

				{!! Form::submit('usuń', [ 'class' => 'btn btn-sm btn-danger']) !!}

			{!! Form::close() !!}


			@if($k-1 >= 0)
				{!! Form::open(['url' => 'admin/gallery/' . $album->slug . '/pictures/swap']) !!}

					{!! Form::hidden('id1', $album->pictures[$k-1]->id) !!}
					{!! Form::hidden('id2', $picture->id) !!}

					{!! Form::submit('w górę', [ 'class' => 'btn-sm btn btn-success']) !!}

				{!! Form::close() !!}

				@endif

				@if($k+1 < count($album->pictures))
				{!! Form::open(['url' => 'admin/gallery/' . $album->slug . '/pictures/swap']) !!}

					{!! Form::hidden('id1', $picture->id) !!}
					{!! Form::hidden('id2', $album->pictures[$k+1]->id) !!}

					{!! Form::submit('w dół', [ 'class' => 'btn-sm btn btn-success']) !!}

				{!! Form::close() !!}
				@endif


				</div>

		</div>

		<div class="clearfix"></div><br>

	@endforeach

	@else 

		<p class="text-muted">Brak zdjęć w tym albumie.</p>

	@endif

	</div>

@stop