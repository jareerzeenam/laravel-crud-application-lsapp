<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// !storage liblery
use Illuminate\Support\Facades\Storage;

// bring the Post Model (jareer)
use App\Post;

// use SQL (jareer)
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
        // This below line blocks you when creating post without logging in
        $this->middleware('auth',['except'=>['index','show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /*Show All Post method 01*/ 
        // $posts = Post::all();

        /*Get post by name method 02*/
        // return Post::where('title','Post Two')->get();

        /*SQL method 03*/
        // $posts = DB::select('SELECT * FROM posts');

         /*Get post by title in descending order method 04*/
        // $posts = Post::orderBy('title','desc')->get();

        /*Limit the number of posts to be shown*/
        //  $posts = Post::orderBy('title','desc')->take(1)->get();

        /*Paginaton*/
        $posts = Post::orderBy('id','desc')->paginate(10);
        
        return view('posts.index')->with('posts',$posts);
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
        /*file create.blade.php*/
        //! store validation 
        $this->validate($request,[
            'title'=>'required',
            'body'=>'required',
            'cover_image'=> 'image|nullable|max:1999'
        ]);

        // !Handle file upload
        if ($request->hasFile('cover_image')) {
            // !Get file name with the extension
            $filenameWithExt = $request->file('cover_image')->getClientOriginalName();

            // !Get just file name
            $filename = pathinfo($filenameWithExt,PATHINFO_FILENAME);
            // !Get just ext 
            $extension = $request->file('cover_image')->getClientOriginalExtension();
            // ! File name to store
            $fileNameToStore = $filename.'_'.time().'.'.$extension;
            // !Upload the image
            $path = $request->file('cover_image')->storeAs('public/cover_images',$fileNameToStore);
        }
        else {
            $fileNameToStore ='noimage.jpg'; 
        }

        // !Create Post
        $post = new Post;
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        // !below line will update record which user  published the post
        $post->user_id = auth()->user()->id;
        $post->cover_image = $fileNameToStore;
        $post ->save();

        return redirect('/posts')->with('success','Post Created Successfully');
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
        return view('posts.show')->with('post',$post);
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

        // !Check for correct user
        if (auth()->user()->id !==$post->user_id) {
             return redirect('/posts')->with('error','Unauthorized Page');
        }
        return view('posts.edit')->with('post',$post);
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
          $this->validate($request,[
            'title'=>'required',
            'body'=>'required'
        ]);

        // !Handle file upload
        if ($request->hasFile('cover_image')) {
            // !Get file name with the extension
            $filenameWithExt = $request->file('cover_image')->getClientOriginalName();

            // !Get just file name
            $filename = pathinfo($filenameWithExt,PATHINFO_FILENAME);
            // !Get just ext 
            $extension = $request->file('cover_image')->getClientOriginalExtension();
            // ! File name to store
            $fileNameToStore = $filename.'_'.time().'.'.$extension;
            // !Upload the image
            $path = $request->file('cover_image')->storeAs('public/cover_images',$fileNameToStore);
        }
       

        // !Create Post
        $post = Post::find($id);
        $post->title = $request->input('title');
        $post->body = $request->input('body');
         if ($request->hasFile('cover_image')) {
             $post->cover_image= $fileNameToStore;
         }
        $post ->save();

        return redirect('/posts')->with('success','Post Updated Successfully');
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

          // !Check for correct user
        if (auth()->user()->id !==$post->user_id) {
             return redirect('/posts')->with('error','Unauthorized Page');
        }

        if ($post->cover_image !='noimage.jpg') {
            // !Delete
            Storage::delete('public/cover_images/'.$post->cover_image);
        }


        $post->delete();

         return redirect('/posts')->with('success','Post Deleted');
    }
}
