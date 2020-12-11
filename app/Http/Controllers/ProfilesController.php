<?php

namespace App\Http\Controllers;
use App\User;
use App\Instrument;
use App\Rules\MatchOldPassword;
use Illuminate\Support\Facades\Hash;


use Illuminate\Http\Request;

class ProfilesController extends Controller
{
    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('/profiles/show')->with('user', $user);
    }

    public function index(){
        $users = User::whereNotNull('approved_at')->get();
        $instruments = Instrument::all();

        return view('/profiles/index', compact('users', 'instruments'));
    }


    public function edit($id)
    {
        $user = User::findOrFail($id);

        //Check user
        if(auth()->user()->id != $user->id){
            return redirect(route('profile.index'))->with('error', 'Nincs jogosultságod a felhasználó szerkesztéséhez');
        }

        return view('/profiles/edit')->with('user', $user);
    }

    public function update(Request $request, $id)
    {

        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
        ]);


        $user = User::find($id);
        if($request->has('publicEvents')){
            $user->public_events_notifications = 1;
        }else{
            $user->public_events_notifications = 0;
        }

        if($request->has('publicPosts')){
            $user->public_posts_notifications = 1;
        }else{
            $user->public_posts_notifications = 0;
        }

        if($request->has('bandEvents')){
            $user->band_events_notifications = 1;
        }else{
            $user->band_events_notifications = 0;
        }

        if($request->has('bandPosts')){
            $user->band_posts_notifications = 1;
        }else{
            $user->band_posts_notifications = 0;
        }

        if($request->has('groupEvents')){
            $user->group_events_notifications = 1;
        }else{
            $user->group_events_notifications = 0;
        }

        if($request->has('groupPosts')){
            $user->group_posts_notifications = 1;
        }else{
            $user->group_posts_notifications = 0;
        }

        if($request->input('current_password') != NULL || $request->input('new_password') != NULL ||$request->input('new_confirm_password') != NULL ){
            $this->validate($request, [
                'current_password' => ['required', new MatchOldPassword],
                'new_password' => 'required',
                'new_confirm_password' => ['same:new_password']
            ]);
                $user->update(['password'=> Hash::make($request->new_password)]);
        }


        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->save();

        return redirect(route('profile.show', $user->id))->with('success', 'Profil frissítve');
    }

    public function uploadPhoto(Request $request){
        $this->validate($request, [
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:1999'
        ]);

        $user = User::findOrFail(Auth()->user()->id) ;

        if($request->hasFile('photo')){
            $filenameWithExt = $request->file('photo')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('photo')->getClientOriginalExtension();
            $fileNameToStore= $filename.'_'.time().'.'.$extension;
            $path = $request->file('photo')->storeAs('public/avatars', $fileNameToStore);
        } else {
            return redirect(route('profile.show', $user->id))->with('error', 'Sikertelen képfeltöltés');
        }

        $user->profile_picture = $fileNameToStore;


        $user->save();
        return redirect(route('profile.show', $user->id))->with('success', 'Sikeres képfeltöltés');

    }


}
