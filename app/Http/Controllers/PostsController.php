<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;

//  For w/o Eloquent usage.
use DB; 

class PostsController extends Controller
{
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
            'body' => 'required'
        ]);

        return 123;
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
        //
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
        //
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
    }
}
