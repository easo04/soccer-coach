@extends('template')

@section('head')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="css/themify-icons/themify-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="css/exercice.css">
@endsection

@section('contenu')
<div class="container p-3 my-3 border container-soccer-coach">
	<br>
	<h3>Liste des types d'exercice</h3>
    <div class="col-sm-offset-4 col-sm-4">
    	@if(session()->has('ok'))
			<div class="alert alert-success alert-dismissible">{!! session('ok') !!}</div>
		@endif
		<div class="panel panel-primary">
			<table class="table">
				<thead>
					<tr>
						<th>#</th>
						<th>Nom</th>
						<th></th>
						<th></th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					@foreach ($typesExercice as $typeExercice)
						<tr>
							<td>{!! $typeExercice->id !!}</td>
							<td class="text-primary"><strong>{!! $typeExercice->nom !!}</strong></td>
							<td>{!! link_to_route('types-exercice.edit', 'Modifier', [$typeExercice->id], ['class' => 'btn btn-warning btn-block']) !!}</td>
							<td>
								{!! Form::open(['method' => 'DELETE', 'route' => ['types-exercice.destroy', $typeExercice->id]]) !!}
									{!! Form::submit('Supprimer', ['class' => 'btn btn-danger btn-block', 'onclick' => 'return confirm(\'Vraiment supprimer ce type dexercice ?\')']) !!}
								{!! Form::close() !!}
							</td>
						</tr>
					@endforeach
	  			</tbody>
			</table>
		</div>
	</div>
	{!! link_to_route('types-exercice.create', 'Ajouter un type dexercice', [], ['class' => 'btn btn-info']) !!}
    {!! $links !!}
</div>
@endsection