@extends('admin.template')

@section('content')

	<h3 class="pull-left">Albums</h3>

	<div class=""> 

		<div class="clearfix"></div>
		@if(count($albums))

		<table class="table table-striped">
			<thead>
				<th>#</th>
				<th>Name</th>
				<th></th>
				<th></th>
				<th>up</th>
				<th>down</th>
			</thead>
			<tbody>
				@foreach($albums as $k => $album)
				<tr>
					<td>{{ $album->id }}</td>
					<td>{{ $album->name }}</td>
					<td>
						<a href="{{ url('admin/gallery/' . $album->id . '/edit') }}" class="btn btn-sm btn-primary">edit</a>
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
						@if($k+1 < count($menu))
						{!! Form::open(['url' => 'admin/gallery/swap']) !!}

							{!! Form::hidden('id1', $album->id) !!}
							{!! Form::hidden('id2', $albums[$k+1]->id) !!}

							{!! Form::submit('move down', [ 'class' => 'btn-sm btn btn-success']) !!}

						{!! Form::close() !!}
						@endif

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