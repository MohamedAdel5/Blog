@extends('layouts.app')

@section('content')
<div class="container p-4">
	<h1>Edit Post {{$post->id}}</h1>

	{{--Note that the method has to be either GET or POST so we keep it POST but we will call a method spoofing function that solves this issue--}}
	{!! Form::open(['action' => ['PostsController@update', $post->id], 'method' => 'POST', 'enctype'=>'multipart/form-data']) !!}
		<div class="form-group ma-2">
			{{Form::label('title', 'Title')}}
			{{Form::text('title', $post->title, ['class'=>'form-control', 'placeholder'=>'Title'])}}
		</div>

		<div class="form-group ma-2">
			{{Form::label('body', 'Body')}}
			{{Form::textarea('body', $post->body, ['id'=>'article-ckeditor', 'class'=>'form-control', 'placeholder'=>'Body text'])}}
		</div>
		<div class="form-group ma-2">
			{{Form::label('cover_image', 'Upload a cover image')}}
			{{Form::file('cover_image')}}
		</div>
		{{Form::hidden('_method', 'PUT')}}
		{{ Form::submit('Submit', ['class'=>'btn btn-primary']) }}
	{!! Form::close() !!}
	<script>
		CKEDITOR.replace('article-ckeditor');
	</script>
</div>
@endsection