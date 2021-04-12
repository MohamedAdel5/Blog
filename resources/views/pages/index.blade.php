@extends('layouts.app')

@section('content')
	<div class="jumbotron text-center">
		<h1>{{$title}}</h1>
		<p>This is the first app in laravel.</p>
		@guest
			<p><a class="btn btn-primary btn-lg" href="/login" role="button">login</a> <a class="btn btn-success btn-lg" href="/register" role="button">register</a></p>
		@endguest
	</div>
@endsection