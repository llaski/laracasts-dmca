@extends('app')

@section('content')
	<h1 class="page-heading">Create Form</h1>

	{!! Form::open(['method' => 'GET', 'action' => 'NoticesController@confirm']) !!}

		<div class="form-group">
			{!! Form::label('provider_id', 'Who are we sending this to?', ['class' => 'form-label']) !!}
			{!! Form::select('provider_id', $providers, null, ['class' => 'form-control']) !!}
		</div>

		<div class="form-group">
			{!! Form::label('infringing_title', 'Title of Content Being Infringed Upon', ['class' => 'form-label']) !!}
			{!! Form::text('infringing_title', null, ['class' => 'form-control']) !!}
		</div>

		<div class="form-group">
			{!! Form::label('infringing_link', 'Link to Infringing Content', ['class' => 'form-label']) !!}
			{!! Form::text('infringing_link', null, ['class' => 'form-control']) !!}
		</div>

		<div class="form-group">
			{!! Form::label('original_link', 'Link to Original Content', ['class' => 'form-label']) !!}
			{!! Form::text('original_link', null, ['class' => 'form-control']) !!}
		</div>

		<div class="form-group">
			{!! Form::label('original_description', 'Extra Info', ['class' => 'form-label']) !!}
			{!! Form::text('original_description', null, ['class' => 'form-control']) !!}
		</div>

		<div class="form-group">
			{!! Form::submit('Preview Notice', ['class' => 'btn btn-primary form-control']) !!}
		</div>

	{!! Form::close() !!}

	@include('errors.list')

@stop