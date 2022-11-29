<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
    use App\User;

    use DB;
    use Auth;
    use App\Post;
    use App\Comment;

class PostController extends Controller
{

    public function index()
    {
        $posts = Post::all();
    
        return view('post.index', compact('posts'));
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
    	$request->validate([   
            'post' => 'required'
        ]);
            $user_id = auth()->id();
	    	$post = $request->input('post');
 
	  		$posts = Post::create([
                'userid' => $user_id,
                'post' => $post

            ]);
 
   
            return response($posts);
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getPost(){
    	$posts = DB::table('posts')->orderBy('created_at', 'desc')->get();
 
		return view('post',['posts' => $posts]);
    }
    
}
