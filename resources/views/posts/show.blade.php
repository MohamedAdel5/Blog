@extends('layouts.app')

@section('content')
		<a href="/posts" class="btn btn-sm btn-secondary align-self-start">Go back</a>
		<div class="card p-3 mt-3 mb-3">
			<h1 class="mt-2">{{$post->title}}</h1>
			<div style="max-width:100%; max-height:500px;">
				<img src="/storage/cover_images/{{$post->cover_image}}" alt="cover image" style="width:100%; height:100%; object-fit: contain;"/>
			</div>
			<br><br>
			<div>
				<p>{!! $post->body !!}</p>
				@auth
					@if (Auth::user()->id == $post->user->id)
						<div class="d-flex justify-content-between">
							<a class="btn btn-sm btn-primary" href="/posts/{{$post->id}}/edit">Edit</a>
							{!! Form::open(['action'=>['PostsController@destroy', $post->id], "method"=>'POST']) !!}
								{{Form::submit('delete', ['class'=>'btn btn-danger btn-sm align-self-end'])}}
								{{Form::hidden('_method', 'DELETE')}}
							{!! Form::close() !!}
						</div>
					@endif
				@endauth
				<hr>
				<small>Written on {{$post->created_at}} by {{$post->user->name}}</small>
			</div>
			</div>
			
@endsection