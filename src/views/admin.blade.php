@extends('admin.template')

@section('content')

	<h3 class="pull-left">Albumy</h3>

	<div class=""> 

		<a href="{{ url('admin/gallery/settings') }}" class="btn btn-default btn-lg pull-right" style="margin-left: 10px;">
			<i class="glyphicon glyphicon-cog"></i>
		</a>

		<a href="{{ url('admin/gallery/create') }}" style="margin-left: 10px" class="btn btn-lg btn-success pull-right">
			Stwórz nowy album
		</a>

		{!! Form::open([ 'url' => 'admin/menu/create']) !!}

			{!! Form::hidden('display_name', 'Galeria') !!}
			{!! Form::hidden('route', 'gallery') !!}
			{!! Form::hidden('params', json_encode([])) !!}

			{!! Form::submit('Dodaj do menu', [ 'class' => 'pull-right btn btn-lg btn-warning']) !!}

		{!! Form::close() !!}

		<div class="clearfix"></div>

		<div class="clearfix"></div>
		@if(count($albums))

		<table class="table table-striped">
			<thead>
				<th>#</th>
				<th>Nazwa</th>
				<th></th>
				<th></th>
				<th></th>
				<th>wyżej</th>
				<th>niżej</th>
				<th></th>
			</thead>
			<tbody>
				@foreach($albums as $k => $album)
				<tr>
					<td>{{ $album->id }}</td>
					<td>{{ $album->name }}</td>
					<td>
						<a href="{{ url('admin/gallery/' . $album->slug . '/pictures') }}" class="btn btn-sm btn-warning"><i class="glyphicon glyphicon-camera"></i> Zdjęcia</a>
					</td>
					<td>
						<a href="{{ url('admin/gallery/' . $album->slug . '/edit') }}" class="btn btn-sm btn-primary">edytuj</a>
					</td>
					<td>
						<a href="{{ url('admin/gallery/' . $album->id . '/delete') }}" class="btn btn-sm btn-danger">usuń</a>
					</td>
					<td>
						@if($k-1 >= 0)
						{!! Form::open(['url' => 'admin/gallery/swap']) !!}

							{!! Form::hidden('id1', $albums[$k-1]->id) !!}
							{!! Form::hidden('id2', $album->id) !!}

							{!! Form::submit('w górę', [ 'class' => 'btn-sm btn btn-success']) !!}

						{!! Form::close() !!}
						@endif
					</td>
					<td>
						@if($k+1 < count($albums))
						{!! Form::open(['url' => 'admin/gallery/swap']) !!}

							{!! Form::hidden('id1', $album->id) !!}
							{!! Form::hidden('id2', $albums[$k+1]->id) !!}

							{!! Form::submit('w dół', [ 'class' => 'btn-sm btn btn-success']) !!}

						{!! Form::close() !!}
						@endif

					</td>
					<td>


						{!! Form::open([ 'url' => 'admin/menu/create']) !!}

							{!! Form::hidden('display_name', $album->name) !!}
							{!! Form::hidden('route', 'gallery/{$slug}') !!}
							{!! Form::hidden('params', json_encode(['slug' => $album->slug])) !!}

							{!! Form::submit('Dodaj do menu', [ 'class' => 'pull-right btn btn-sm btn-warning']) !!}

						{!! Form::close() !!}


					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
		@else
			<p class="text-muted">Brak dodanych albumów.</p>
		@endif

	</div>

@stop