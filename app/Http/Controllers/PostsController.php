<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Post;
// use DB; //This works just fine but intelphense moans about it.
use Illuminate\Support\Facades\DB; //Use this instead

class PostsController extends Controller
{

		public function __construct()
		{
			$this->middleware('auth', ['except' => ['index', 'show']]);
		}
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
				// $specialPost = Post::where('title', 'Second Post');

				// $posts = Post::orderBy('created_at', 'desc')->take(1)->get(); //use take to limit the result
				$posts = Post::orderBy('created_at', 'desc')->paginate(5); //use paginate instead of get to do pagination (this function reads the query parameter page and paginates accordingly)
				// $posts = Post::orderBy('created_at', 'desc')->get();
				// $posts = DB::select('SELECT * FROM posts ORDER BY created_at DESC'); // same as the prev statement
        return view('posts.index')->with('posts', $posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
					'title'=>'required',
					'body'=>'required',
					'cover_image' => 'image|nullable|max:1999'
				]);

				//Handle file upload
				$fileNameToStore = 'noimage.jpg';
				if($request->hasFile('cover_image'))
				{
					$fileNameWithExt = $request->file('cover_image')->getClientOriginalName();
					$extension = $request->file('cover_image')->getClientOriginalExtension();
					$fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
					$fileNameToStore = $fileName . '_' . time() . '.' . $extension;

					//Upload the image
					//The image by default is in folder /storage/app/public but this location isnt accessible by the browser 
					//(if the browser sends a get request for the image the only accessible location is at public folder).
					//So we run the command `php artisan storage:link` to make a folder that exists in the public folder and links to the storage folder.
					$path = $request->file('cover_image')->storeAs('public/cover_images', $fileNameToStore);
				}

				$post = new Post();
				$post->title = $request->input('title');
				$post->body = $request->input('body');
				$post->user_id = auth()->user()->id;
				$post->cover_image = $fileNameToStore;
				$post->save();
				return redirect('/posts')->with('success', 'Post Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
				$post = Post::find($id);
        return view('posts.show')->with('post', $post);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::find($id);
				if($post->user_id == auth()->user()->id)
					return view('posts.edit')->with('post', $post);
				else
					return redirect('/posts')->with('error', "Unauthorized action.");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
			
        $this->validate($request, [
					'title'=>'required',
					'body'=>'required',
					'cover_image' => 'image|nullable|max:1999'
				]);

				$post = Post::find($id);
				if($post->user_id != auth()->user()->id)
					return redirect('/posts')->with('error', "Unauthorized action.");

					

				//Handle file upload
				$fileNameToStore = '';
				if($request->hasFile('cover_image'))
				{
					$fileNameWithExt = $request->file('cover_image')->getClientOriginalName();
					$extension = $request->file('cover_image')->getClientOriginalExtension();
					$fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
					$fileNameToStore = $fileName . '_' . time() . '.' . $extension;

					//Upload the image
					//The image by default is in folder /storage/app/public but this location isnt accessible by the browser 
					//(if the browser sends a get request for the image the only accessible location is at public folder).
					//So we run the command `php artisan storage:link` to make a folder that exists in the public folder and links to the storage folder.
					$path = $request->file('cover_image')->storeAs('public/cover_images', $fileNameToStore);
				}
				$post->title = $request->input('title');
				$post->body = $request->input('body');
				if($request->hasFile('cover_image'))
				{
					Storage::delete('public/cover_images/' . $post->cover_image);
					$post->cover_image = $fileNameToStore;
				}
				$post->save();
				return redirect("/posts/".$post->id)->with('success', 'Post updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
				$post = Post::find($id);
				if($post->user_id != auth()->user()->id)
					return redirect('/posts')->with('error', "Unauthorized action.");

				if($post->cover_image != 'noimage.jpg')
				{
					//delete the image
					Storage::delte('public/cover_images/'.$post->cover_image);
				}
				$post->delete();
				return redirect("/posts")->with('success', 'Post deleted successfully');
    }
}
