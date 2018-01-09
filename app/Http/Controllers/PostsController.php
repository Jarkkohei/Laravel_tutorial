<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;

//  For w/o Eloquent usage.
use DB; 

class PostsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //  Apply AuthGuard with exceptions. (Allows guests access "index"- and "show"-pages.)
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //  Fetch all posts
        //$posts = Post::all();

        //  Fetch all posts with the title of "Post Two".
        //$posts = Post::where('title', 'Post Two')->get();

        //  Example for using DB instead of Eloquent.
        //$posts = DB:select('SELECT * FROM posts');

        //  Fetch only the most recent post (one!).
        //$posts = Post::orderBy('created_at', 'desc')->take(1)->get();


        //  Fetch all posts, order by creation date/time in descending order. (recent post first)
        //$posts = Post::orderBy('created_at', 'desc')->get();


        //  Paginate the results, one / page.
        $posts = Post::orderBy('created_at', 'desc')->paginate(10);
        
        //  Load view with the fetched posts
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
            'title' => 'required',
            'body' => 'required',
            'cover_image' => 'image|nullable|max:1999'
        ]);

        //  Handle File Upload
        if($request->hasFile('cover_image')) {

            //  Get filename with the extension
            $filenameWithExt = $request->file('cover_image')->getClientOriginalName();

            //  Extract only the filename (=ditch the extension)
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);

            //  Extract only the extension (=ditch the filename)
            $extension = $request->file('cover_image')->getClientOriginalExtension();

            //  Filename to store (=add a timestamp to the filename to make it unique)
            $fileNameToStore = $filename.'_'.time().'.'.$extension;

            //  Upload the image
            $path = $request->file('cover_image')->storeAs('public/cover_images', $fileNameToStore);

        } else {
            $fileNameToStore = 'noimage.jpg';
        }

        //  Create Post
        $post = new Post;
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

        //  Check for user authentication
        if(auth()->user()->id !== $post->user_id) {
            return redirect('/posts')->with('error', 'Unauthorized page');
        }


        return view('posts.edit')->with('post', $post);
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
            'title' => 'required',
            'body' => 'required'
        ]);

        //  Update Post
        $post = Post::find($id);

        //  Check for user authentication
        if(auth()->user()->id !== $post->user_id) {
            return redirect('/posts')->with('error', 'Unauthorized page');
        }
        
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        $post->save();

        return redirect('/posts')->with('success', 'Post Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);

        //  Check for user authentication
        if(auth()->user()->id !== $post->user_id) {
            return redirect('/posts')->with('error', 'Unauthorized page');
        }

        $post->delete();

        return redirect('/posts')->with('success', 'Post Removed');
    }
}
