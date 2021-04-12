@extends('layouts.app')

@section('content')
		<div class="container p-4">
			<h1>Create Post</h1>

			{!! Form::open(['action' => 'PostsController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
				<div class="form-group ma-2">
					{{Form::label('title', 'Title')}}
					{{Form::text('title', '', ['class'=>'form-control', 'placeholder'=>'Title'])}}
				</div>

				<div class="form-group ma-2">
					{{Form::label('body', 'Body')}}
					{{Form::textarea('body', '', ['id'=>'article-ckeditor', 'class'=>'form-control', 'placeholder'=>'Body text'])}}
				</div>
				<div class="form-group ma-2">
					{{Form::label('cover_image', 'Upload a cover image')}}
					{{Form::file('cover_image')}}
				</div>
				{{ Form::submit('Submit') }}
			{!! Form::close() !!}

		</div>
		<script>
			CKEDITOR.replace('article-ckeditor');
		</script>
@endsection