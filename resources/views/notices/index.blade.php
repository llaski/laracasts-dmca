@extends('app')

@section('content')
	<h1 class="page-heading">Your Notices</h1>

	<table class="table table-striped table-bordered">
		<thead>
			<tr>
				<th colspan="5">Active Notices</th>
			</tr>
			<tr>
				<th>This Content</th>
				<th>Accesssible Here</th>
				<th>Infringing Upon My Work Here</th>
				<th>Notice Sent</th>
				<th>Content Removed</th>
			</tr>
		</thead>
		<tbody>
			@foreach($notices as $notice)
				<tr>
					<td>{{ $notice->infringing_title }}</td>
					<td>{!! link_to($notice->infringing_link) !!}</td>
					<td>{!! link_to($notice->original_link) !!}</td>
					<td>{{ $notice->created_at->diffForHumans() }}</td>
					<td>
						{!! Form::open(['method' => 'PATCH', 'url' => 'notices/' . $notice->id, 'data-remote']) !!}
							<div class="form-group">
								{!! Form::checkbox('content_removed', $notice->content_removed, $notice->content_removed, ['data-change-submit-form']) !!}
							</div>
						{!! Form::close() !!}
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>

	@unless(count($notices))
		<p class="text-center">No notices sent yet.</p>
	@endunless
@stop