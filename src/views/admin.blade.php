@extends('admin.template')

@section('content')

	<h3 class="pull-left">Albums</h3>

	<div class=""> 

		<a href="{{ url('admin/gallery/settings') }}" class="btn btn-default btn-lg pull-right" style="margin-left: 10px;">
			<i class="glyphicon glyphicon-cog"></i>
		</a>

		<a href="{{ url('admin/gallery/create') }}" style="margin-left: 10px" class="btn btn-lg btn-success pull-right">
			Create new album
		</a>

		{!! Form::open([ 'url' => 'admin/menu/create']) !!}

			{!! Form::hidden('display_name', 'Gallery') !!}
			{!! Form::hidden('route', 'gallery') !!}
			{!! Form::hidden('params', json_encode([])) !!}

			{!! Form::submit('Add to menu', [ 'class' => 'pull-right btn btn-lg btn-warning']) !!}

		{!! Form::close() !!}

		<div class="clearfix"></div>

		<div class="clearfix"></div>
		@if(count($albums))

		<table class="table table-striped">
			<thead>
				<th>#</th>
				<th>Name</th>
				<th></th>
				<th></th>
				<th></th>
				<th>up</th>
				<th>down</th>
				<th></th>
			</thead>
			<tbody>
				@foreach($albums as $k => $album)
				<tr>
					<td>{{ $album->id }}</td>
					<td>{{ $album->name }}</td>
					<td>
						<a href="{{ url('admin/gallery/' . $album->slug . '/pictures') }}" class="btn btn-sm btn-warning">Pictures</a>
					</td>
					<td>
						<a href="{{ url('admin/gallery/' . $album->slug . '/edit') }}" class="btn btn-sm btn-primary">edit</a>
					</td>
					<td>
						<a href="{{ url('admin/gallery/' . $album->id . '/delete') }}" class="btn btn-sm btn-danger">delete</a>
					</td>
					<td>
						@if($k-1 >= 0)
						{!! Form::open(['url' => 'admin/gallery/swap']) !!}

							{!! Form::hidden('id1', $albums[$k-1]->id) !!}
							{!! Form::hidden('id2', $album->id) !!}

							{!! Form::submit('move up', [ 'class' => 'btn-sm btn btn-success']) !!}

						{!! Form::close() !!}
						@endif
					</td>
					<td>
						@if($k+1 < count($albums))
						{!! Form::open(['url' => 'admin/gallery/swap']) !!}

							{!! Form::hidden('id1', $album->id) !!}
							{!! Form::hidden('id2', $albums[$k+1]->id) !!}

							{!! Form::submit('move down', [ 'class' => 'btn-sm btn btn-success']) !!}

						{!! Form::close() !!}
						@endif

					</td>
					<td>


						{!! Form::open([ 'url' => 'admin/menu/create']) !!}

							{!! Form::hidden('display_name', $album->name) !!}
							{!! Form::hidden('route', 'gallery/{$slug}') !!}
							{!! Form::hidden('params', json_encode(['slug' => $album->slug])) !!}

							{!! Form::submit('Add to menu', [ 'class' => 'pull-right btn btn-sm btn-warning']) !!}

						{!! Form::close() !!}


					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
		@else
			<p class="text-muted">No albums found.</p>
		@endif

	</div>

@stop