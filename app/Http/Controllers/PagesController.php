<?php

namespace App\Http\Controllers;
use App\Post;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function home(){
        $post = Post::where('visibility_id','=', 1)->paginate(5);
        return view('posts/index')->with('posts', $post);
    }
}
