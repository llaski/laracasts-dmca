@extends('app')

@section('content')
	<h1 class="page-heading">Confirm</h1>

	{!! Form::open(['action' => 'NoticesController@store']) !!}

		<div class="form-group">
			{!! Form::label('template', 'Template:', ['class' => 'form-label']) !!}
			{!! Form::textarea('template', $template, ['class' => 'form-control']) !!}
		</div>

		<div class="form-group">
			{!! Form::submit('Deliver DMCA Notice', ['class' => 'btn btn-primary form-control']) !!}
		</div>

	{!! Form::close() !!}

	@include('errors.list')

@stop