@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <a class="btn btn-lg btn-primary" href="/posts/create">Create Post</a>
										<hr>
										<h3>Your Blog</h3>
										{{-- <div>
											<p>Samples of your posts</p>
											<p>..</p>
											<p>..</p>
											<p>..</p>
											<a class="btn btn-sm btn-secondary" href="/posts">Show all</a>
										</div> --}}
										@if (count($posts) > 0)
											<table class="table table-striped">
												<tr>
													<th>Title</th>
													<th></th>
													<th></th>
												</tr>
												@foreach ($posts as $post)
												<tr>
													<td>{{$post->title}}</td>
													<td><a class="btn btn-sm btn-secondary" href="/posts/{{$post->id}}/edit">Edit</a></td>
													<td>
														{!! Form::open(['action'=>['PostsController@destroy', $post->id], "method"=>'POST']) !!}
															{{Form::submit('delete', ['class'=>'btn btn-danger btn-sm align-self-end'])}}
															{{Form::hidden('_method', 'DELETE')}}
														{!! Form::close() !!}
													</td>
												</tr>
												@endforeach
											</table>
										@else		
											<p>You have no posts yet.</p>
										@endif
										
										<hr>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
