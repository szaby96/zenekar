<?php

namespace App\Http\Controllers;

use App\Notifications\PostCreated;
use Illuminate\Http\Request;
use App\Post;
use App\User;
use App\Visibility;
use validator;
use Auth;
use Notification;
use Illuminate\Support\Carbon;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($visibility_name = NULL){
        if($visibility_name == 'public'){
            $post = Post::where('visibility_id','=', 1)->orderBy('created_at', 'desc')->paginate(5);
            return view('posts/index')->with('posts', $post);
        }
        if(Auth::check() && Auth::user()->approved_at){
            if($visibility_name == NULL ){
                $post = Post::where('visibility_id','=', 1)
                ->orWhere('visibility_id', '=', 2)
                ->orWhere(function ($q) {
                    $q->where('visibility_id', '=', 3)
                    ->where('instrument_id', '=', Auth::user()->intrument_id);
                })->orderBy('created_at', 'desc')->paginate(5);
                return view('posts/index')->with('posts', $post);
            }elseif($visibility_name == 'private'){
                $post = Post::where('visibility_id','=', 2)->orderBy('created_at', 'desc')->paginate(5);
                return view('posts/index')->with('posts', $post);
            }elseif($visibility_name == 'instrument'){
                $post = Post::where('visibility_id','=', 3)->where('instrument_id', '=', Auth::user()->instrument_id)->orderBy('created_at', 'desc')->paginate(5);
                return view('posts/index')->with('posts', $post);
            }else{
                return redirect(route('posts.index'));
            }
        }else{
            return redirect(route('posts.index', 'public'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts/create');
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
            'visibility' => 'required'
        ]);

        $post = new Post;
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        $post->user_id = Auth::user()->id;
        $post->visibility_id = $request->input('visibility');
        if($request->input('visibility') == 3){
            $post->instrument_id = Auth::user()->instrument_id;
        }
        $post->save();

        //delay notifications
        $delaySec = 0;

        if($request->input('visibility') == 1){
            $users = User::where('public_posts_notifications','=', 1)->get();
            foreach($users as $user){
                $when = Carbon::now()->addSeconds($delaySec);
                Notification::send($user, (new PostCreated($post))->delay($when));
                $delaySec += 10;
            }
        }
        elseif($request->input('visibility') == 2){
            $users = User::where('band_posts_notifications','=', 1)->get();
            foreach($users as $user){
                $when = Carbon::now()->addSeconds($delaySec);
                Notification::send($user, (new PostCreated($post))->delay($when));
                $delaySec += 10;
            }
        }elseif($request->input('visibility') == 3){
            $users = User::where('group_posts_notifications','=', 1)->where('instrument_id', '=', $post->instrument_id)->get();
            foreach($users as $user){
                $when = Carbon::now()->addSeconds($delaySec);
                Notification::send($user, (new PostCreated($post))->delay($when));
                $delaySec += 10;
            }
        }

        return redirect(route('posts.index', $post->visibility->name))->with('success', 'Poszt létrehozva');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::findOrFail($id);
        return view('/posts/show')->with('post', $post);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::findOrFail($id);

        //Check user
        if(auth()->user()->id != $post->user_id){
            return redirect(route('posts.index', $post->visibility->name))->with('error', 'Nincs jogosultságod a poszt szerkesztéséhez');
        }

        return view('/posts/edit')->with('post', $post);
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

        $post = Post::find($id);
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        $post->save();

        return redirect(route('post.show', $post->id))->with('success', 'Poszt szerkesztve');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::where('id', '=', $id)->first();

        //Check user
            if(Auth::user()->id == $post->user_id || Auth::user()->right_id == 3){
                $post->delete();
                return redirect(route('posts.index', $post->visibility->name))->with('success', 'Poszt törölve');
            }else{
                return redirect(route('posts.index', $post->visibility->name))->with('error', 'Nincs jogosultságod a poszt törléséhez');
            }
    }
}
